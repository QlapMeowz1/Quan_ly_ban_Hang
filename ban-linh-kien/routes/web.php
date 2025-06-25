<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmailVerificationController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductReviewController;
use Illuminate\Support\Facades\Auth;
use App\Models\SpinHistory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect('/home');
})->name('welcome');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Cart routes
Route::get('/cart', function () {
    $cart = session('cart', []);
    $products = \App\Models\Product::whereIn('product_id', array_keys($cart))->get();
    return view('cart', compact('cart', 'products'));
})->name('cart.index');

Route::post('/cart/add', function (\Illuminate\Http\Request $request) {
    $cart = session('cart', []);
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1);

    $product = \App\Models\Product::find($productId);
    if (!$product || $product->status !== 'active' || $product->stock_quantity < 1) {
        return redirect()->route('cart.index')->with('error', 'Sản phẩm này hiện đang ngừng bán hoặc hết hàng!');
    }

    if (isset($cart[$productId])) {
        $cart[$productId] += $quantity;
    } else {
        $cart[$productId] = $quantity;
    }
    session(['cart' => $cart]);
    return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
})->name('cart.add');

Route::post('/cart/remove', function (\Illuminate\Http\Request $request) {
    $cart = session('cart', []);
    $productId = $request->input('product_id');
    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session(['cart' => $cart]);
    }
    return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
})->name('cart.remove');


Auth::routes(['verify' => false]);

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'showVerificationForm'])->name('verification.form');
    Route::post('/email/verify', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'passwordForm'])->name('profile.password');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/checkout', function () {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        $products = \App\Models\Product::whereIn('product_id', array_keys($cart))->get();
        return view('checkout', compact('cart', 'products'));
    })->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('admins', App\Http\Controllers\AdminController::class);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('brands', App\Http\Controllers\BrandController::class);
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/orders', [App\Http\Controllers\AdminController::class, 'userOrders'])->name('users.orders');
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'list'])->name('orders.list');
    Route::get('orders/{order_id}/edit-status', [\App\Http\Controllers\Admin\OrderController::class, 'editStatus'])->name('orders.edit_status');
    Route::post('orders/{order_id}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::get('orders/{order_id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class);
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('products.reviews.store')->middleware(['auth', 'verified']);

// Quên mật khẩu
Route::get('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password');
Route::post('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot-password.post');

// Đặt lại mật khẩu
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Checkout Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{orderId}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/checkout/bank-transfer/{orderId}', [App\Http\Controllers\CheckoutController::class, 'bankTransfer'])->name('checkout.bank-transfer');
    Route::get('/checkout/vnpay/{orderId}', [App\Http\Controllers\CheckoutController::class, 'vnpay'])->name('checkout.vnpay');
});

// VNPay Routes  
Route::get('/vnpay/return', [App\Http\Controllers\CheckoutController::class, 'returnPayment'])->name('vnpay.return');
Route::post('/vnpay/notify', [App\Http\Controllers\CheckoutController::class, 'ipnPayment'])->name('vnpay.notify'); 