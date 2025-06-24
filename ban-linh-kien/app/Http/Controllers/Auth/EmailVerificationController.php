<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmailVerificationService;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    protected $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
        $this->middleware('auth')->except(['verify', 'resend']);
    }

    /**
     * Hiển thị form nhập OTP
     */
    public function showVerificationForm()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xác thực email.');
        }

        $customer = $user->customer;
        if (!$customer) {
            return redirect()->route('home')->with('error', 'Không tìm thấy thông tin khách hàng.');
        }

        // Nếu đã xác thực rồi thì chuyển về trang chủ
        if ($customer->email_verified) {
            return redirect()->route('home')->with('success', 'Email đã được xác thực!');
        }

        return view('auth.verify-email', compact('customer'));
    }

    /**
     * Xác thực OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP',
            'otp.digits' => 'Mã OTP phải có 6 chữ số'
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xác thực email.');
        }

        $customer = $user->customer;
        if (!$customer) {
            return back()->with('error', 'Không tìm thấy thông tin khách hàng.');
        }

        // Xác thực OTP
        $result = $this->emailVerificationService->verifyOTP($customer, $request->otp);

        if ($result['success']) {
            return redirect()->route('home')->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Gửi lại mã OTP
     */
    public function resend(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để gửi lại OTP.']);
        }

        $customer = $user->customer;
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thông tin khách hàng.']);
        }

        if ($customer->email_verified) {
            return response()->json(['success' => false, 'message' => 'Email đã được xác thực!']);
        }

        // Kiểm tra thời gian gửi lại (chống spam)
        if ($customer->email_otp_expires_at && Carbon::parse($customer->email_otp_expires_at)->isFuture()) {
            $remainingTime = Carbon::parse($customer->email_otp_expires_at)->diffInSeconds(Carbon::now());
            if ($remainingTime > 480) { // Còn hơn 8 phút (10-2=8 phút)
                return response()->json([
                    'success' => false, 
                    'message' => 'Vui lòng đợi ít nhất 2 phút trước khi gửi lại OTP.'
                ]);
            }
        }

        // Tạo OTP mới
        $otp = $this->emailVerificationService->generateOTP();
        $this->emailVerificationService->saveOTPToCustomer($customer, $otp);

        // Gửi email
        $emailSent = $this->emailVerificationService->sendVerificationEmail($customer, $otp);

        if ($emailSent) {
            return response()->json([
                'success' => true, 
                'message' => 'Đã gửi lại mã OTP đến email của bạn!'
            ]);
        } else {
            return response()->json([
                'success' => false, 
                'message' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau!'
            ]);
        }
    }

    /**
     * Gửi OTP cho khách hàng mới đăng ký
     */
    public function sendVerificationEmail($customer)
    {
        // Tạo OTP
        $otp = $this->emailVerificationService->generateOTP();
        
        // Lưu OTP vào database
        $this->emailVerificationService->saveOTPToCustomer($customer, $otp);
        
        // Gửi email
        return $this->emailVerificationService->sendVerificationEmail($customer, $otp);
    }
} 