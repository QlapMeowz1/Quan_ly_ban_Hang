<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Notifications\EmailVerificationOTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    /**
     * Show email verification form
     */
    public function show(Request $request)
    {
        $email = $request->get('email');
        
        if (!$email) {
            return redirect()->route('login')->with('error', 'Email không hợp lệ');
        }

        $customer = Customer::where('email', $email)->first();
        
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Không tìm thấy tài khoản');
        }

        if ($customer->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Email đã được xác thực');
        }

        return view('auth.verify-email', compact('customer'));
    }

    /**
     * Send verification OTP
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email'
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer = Customer::where('email', $request->email)->first();

        if ($customer->hasVerifiedEmail()) {
            return back()->with('error', 'Email đã được xác thực');
        }

        // Generate OTP
        $otp = $customer->generateEmailOTP();

        // Send OTP email
        try {
            $customer->notify(new EmailVerificationOTP($otp));
            
            return back()->with('success', 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại.');
        }
    }

    /**
     * Verify OTP
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email',
            'otp' => 'required|string|min:6|max:6'
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống',
            'otp.required' => 'Mã OTP là bắt buộc',
            'otp.min' => 'Mã OTP phải có 6 số',
            'otp.max' => 'Mã OTP phải có 6 số'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer = Customer::where('email', $request->email)->first();

        if ($customer->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Email đã được xác thực');
        }

        // Verify OTP
        if ($customer->verifyEmailOTP($request->otp)) {
            return redirect()->route('login')->with('success', 'Email đã được xác thực thành công! Bạn có thể đăng nhập ngay bây giờ.');
        } else {
            if ($customer->isEmailOTPExpired()) {
                return back()->with('error', 'Mã OTP đã hết hạn. Vui lòng yêu cầu mã mới.');
            } else {
                return back()->with('error', 'Mã OTP không đúng. Vui lòng kiểm tra lại.');
            }
        }
    }

    /**
     * Resend OTP
     */
    public function resend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $customer = Customer::where('email', $request->email)->first();

        if ($customer->hasVerifiedEmail()) {
            return back()->with('error', 'Email đã được xác thực');
        }

        // Generate new OTP
        $otp = $customer->generateEmailOTP();

        // Send OTP email
        try {
            $customer->notify(new EmailVerificationOTP($otp));
            
            return back()->with('success', 'Mã OTP mới đã được gửi đến email của bạn.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại.');
        }
    }
} 