<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function index(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(401);
        }

   
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        $cartItems = collect();
        $subtotal = 0;
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::with('images')->find($productId);
            if ($product && $product->status === 'active') {
                //kiểm tra  kho
                if ($quantity > $product->stock_quantity) {
                    return redirect()->route('cart.index')
                        ->with('error', "Sản phẩm {$product->product_name} chỉ còn {$product->stock_quantity} sản phẩm trong kho");
                }
                
                $cartItem = (object) [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
                
                $cartItems->push($cartItem);
                $subtotal += $product->price * $quantity;
            }
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không có sản phẩm hợp lệ');
        }

        $shipping = $this->calculateShipping($subtotal);
        $tax = $this->calculateTax($subtotal);
        $total = $subtotal + $shipping + $tax;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        Log::info('Checkout request received', $request->all());

        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_ward' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,bank_transfer,vnpay',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            Log::warning('Checkout validation failed', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy cart từ session
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();

        try {
            // Lấy thông tin customer
            $customer = $user->customer;
            if (!$customer) {
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'password_hash' => $user->password,
                    'first_name' => $user->name,
                    'status' => 'active',
                    'email_verified' => 1,
                ]);
            }

            // Kiểm tra tồn kho và tính toán chi phí
            $subtotal = 0;
            $orderItems = [];
            
            foreach ($cart as $productId => $quantity) {
                $product = Product::with('images')->find($productId);
                if (!$product || $product->status !== 'active') {
                    throw new \Exception("Sản phẩm không hợp lệ");
                }
                
                if ($quantity > $product->stock_quantity) {
                    throw new \Exception("Sản phẩm {$product->product_name} không đủ số lượng trong kho");
                }
                
                $itemTotal = $product->price * $quantity;
                $subtotal += $itemTotal;
                
                $orderItems[] = [
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'product_code' => $product->product_code,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $itemTotal,
                ];
            }

            $shipping = $this->calculateShipping($subtotal);
            $tax = $this->calculateTax($subtotal);
            $total = $subtotal + $shipping + $tax;

            // Tạo đơn hàng
            $order = Order::create([
                'customer_id' => $customer->customer_id,
                'order_number' => $this->generateOrderNumber(),
                'order_date' => now(),
                'order_status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_district' => $request->shipping_district,
                'shipping_ward' => $request->shipping_ward,
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'notes' => $request->notes,
            ]);

            Log::info('Order created successfully', ['order_id' => $order->order_id]);

            // Tạo order items (trigger sẽ tự động cập nhật tồn kho)
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            // Xóa giỏ hàng từ session
            session()->forget('cart');

            DB::commit();

            Log::info('Checkout completed successfully', ['order_id' => $order->order_id]);

            return $this->handlePayment($order, $request->payment_method);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());

            return redirect()->route('checkout.index')
                ->with('error', 'Đã xảy ra lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    /**
     * Kiểm tra xem sản phẩm có biến thể thực sự hay không
     * 
     * @param int $productId
     * @return bool
     */
    private function productHasRealVariants(int $productId): bool
    {
        // Đếm số lượng biến thể của sản phẩm
        $variantCount = ProductVariant::where('product_id', $productId)->count();

        // Nếu có nhiều hơn 1 biến thể, thì chắc chắn có biến thể thực sự
        if ($variantCount > 1) {
            return true;
        }

        // Nếu chỉ có 1 biến thể, kiểm tra xem có phải biến thể mặc định không
        if ($variantCount == 1) {
            $variant = ProductVariant::where('product_id', $productId)->first();

            // Nếu biến thể có tên khác "Mặc định" hoặc "Phiên bản mặc định"
            // và không phải variant_id = 1, thì coi như có biến thể thực sự
            if (
                $variant &&
                $variant->variant_id != 1 &&
                $variant->variant_name != 'Mặc định' &&
                $variant->variant_name != 'Phiên bản mặc định'
            ) {
                return true;
            }
        }

        // Mặc định coi như không có biến thể thực sự
        return false;
    }

    private function handlePayment(Order $order, string $paymentMethod): RedirectResponse
    {
        switch ($paymentMethod) {
            case 'cod':
                return redirect()->route('checkout.success', ['orderId' => $order->order_id])
                    ->with('success', 'Đặt hàng thành công! Bạn sẽ thanh toán khi nhận hàng.');
            case 'bank_transfer':
                return redirect()->route('checkout.bank-transfer', ['orderId' => $order->order_id]);
            case 'vnpay':
                return redirect()->route('checkout.vnpay', ['orderId' => $order->order_id]);   
            default:
                return redirect()->route('checkout.success', ['orderId' => $order->order_id]);
        }
    }

    private function calculateShipping(float $subtotal): float
    {
        return $subtotal >= 500000 ? 0 : 30000;
    }

    private function calculateTax(float $subtotal): float
    {
        return $subtotal * 0.1;
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'LK' . date('Ymd') . rand(1000, 9999);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    public function success($orderId): View
    {
        $order = Order::with(['orderItems.product.images'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    public function cancel(): View
    {
        return view('checkout.cancel');
    }

    public function bankTransfer($orderId): View
    {
        $order = Order::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.bank-transfer', compact('order'));
    }




public function vnpay($orderId)
{
    $order = Order::findOrFail($orderId);

    // Validate VNPay configuration
    $vnp_TmnCode = env('VNP_TMNCODE');
    $vnp_HashSecret = env('VNP_HASHSECRET');
    
    if (!$vnp_TmnCode || !$vnp_HashSecret) {
        return redirect()->route('checkout.success', ['orderId' => $order->order_id])
            ->with('error', 'Cấu hình VNPay chưa được thiết lập. Vui lòng liên hệ quản trị viên.');
    }

    $vnp_Url = env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
    $vnp_Returnurl = route('vnpay.return');

    $vnp_TxnRef = $order->order_id;
    $vnp_OrderInfo = "Thanh toán đơn hàng LinhKien #" . $order->order_number;
    $vnp_OrderType = "billpayment";
    $vnp_Amount = $order->total_amount * 100;
    $vnp_Locale = "vn";
    $vnp_IpAddr = request()->ip();

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    ];

    ksort($inputData);
    $hashdata = '';
    $query = '';
    $i = 0;
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $hashdata = rtrim($hashdata, '&');
    $query = rtrim($query, '&');

    $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= "?" . $query . '&vnp_SecureHash=' . $vnp_SecureHash;

    return redirect($vnp_Url);
}

public function returnPayment(Request $request)
{
    $vnp_ResponseCode = $request->input('vnp_ResponseCode');
    $vnp_TxnRef = $request->input('vnp_TxnRef');

    if ($vnp_ResponseCode === '00') {
        $order = Order::where('order_id', $vnp_TxnRef)->first();

        if ($order && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'payment_method' => 'vnpay',
                'status' => 'confirmed',
            ]);
        }

        return redirect()->route('checkout.success', ['orderId' => $order->order_id]);
    }

    return redirect()->route('checkout.cancel')->with('message', 'Thanh toán thất bại');
}

public function ipnPayment(Request $request)
{
    $vnp_ResponseCode = $request->input('vnp_ResponseCode');
    $vnp_TxnRef = $request->input('vnp_TxnRef');

    if ($vnp_ResponseCode === '00') {
        $order = Order::where('order_id', $vnp_TxnRef)->first();

        if ($order && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'payment_method' => 'vnpay',
                'status' => 'confirmed',
            ]);
        }
    }

    return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
}



}