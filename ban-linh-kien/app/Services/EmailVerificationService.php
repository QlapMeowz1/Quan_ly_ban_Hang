<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Customer;
use Carbon\Carbon;

class EmailVerificationService
{
    public function sendVerificationEmail($customer, $otp)
    {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '23010416@st.phenikaa-uni.edu.vn'; // Email của bạn
            $mail->Password = 'acagdicqhdlmnmah'; // App password của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';

            // Người gửi
            $mail->setFrom('23010416@st.phenikaa-uni.edu.vn', 'Hệ thống bán linh kiện');
            
            // Người nhận
            $mail->addAddress($customer->email, $customer->first_name . ' ' . $customer->last_name);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Xác thực email - Mã OTP';
            
            $emailBody = $this->getEmailTemplate($customer, $otp);
            $mail->Body = $emailBody;
            $mail->AltBody = "Mã OTP xác thực email của bạn là: $otp. Mã này có hiệu lực trong 10 phút.";

            $mail->send();
            return true;

        } catch (Exception $e) {
            \Log::error("Không thể gửi email: {$mail->ErrorInfo}");
            return false;
        }
    }

    private function getEmailTemplate($customer, $otp)
    {
        $customerName = $customer->first_name . ' ' . $customer->last_name;
        if (empty(trim($customerName))) {
            $customerName = $customer->email;
        }

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Xác thực Email</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
                .otp-box { background: #fff; border: 2px dashed #007bff; padding: 20px; margin: 20px 0; text-align: center; border-radius: 8px; }
                .otp-code { font-size: 32px; font-weight: bold; color: #007bff; letter-spacing: 5px; }
                .footer { text-align: center; margin-top: 20px; font-size: 14px; color: #666; }
                .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔐 Xác Thực Email</h1>
                    <p>Hệ thống bán linh kiện máy tính</p>
                </div>
                <div class='content'>
                    <h3>Xin chào <strong>$customerName</strong>,</h3>
                    <p>Cảm ơn bạn đã đăng ký tài khoản tại hệ thống của chúng tôi!</p>
                    <p>Để hoàn tất quá trình đăng ký, vui lòng sử dụng mã OTP bên dưới để xác thực email:</p>
                    
                    <div class='otp-box'>
                        <p>Mã OTP của bạn:</p>
                        <div class='otp-code'>$otp</div>
                        <p><small>Mã này có hiệu lực trong <strong>10 phút</strong></small></p>
                    </div>

                    <p><strong>Lưu ý:</strong></p>
                    <ul>
                        <li>Mã OTP chỉ sử dụng được một lần</li>
                        <li>Không chia sẻ mã này với bất kỳ ai</li>
                        <li>Nếu bạn không yêu cầu xác thực này, vui lòng bỏ qua email</li>
                    </ul>

                    <div style='text-align: center; margin-top: 30px;'>
                        <a href='" . route('verification.form') . "' class='btn'>Xác thực ngay</a>
                    </div>
                </div>
                <div class='footer'>
                    <p>© 2024 Hệ thống bán linh kiện máy tính. Mọi quyền được bảo lưu.</p>
                    <p>Email này được gửi tự động, vui lòng không trả lời.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    public function generateOTP()
    {
        return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function saveOTPToCustomer($customer, $otp)
    {
        $customer->update([
            'email_otp' => $otp,
            'email_otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    public function verifyOTP($customer, $inputOtp)
    {
        // Kiểm tra OTP có hợp lệ không
        if ($customer->email_otp !== $inputOtp) {
            return ['success' => false, 'message' => 'Mã OTP không đúng!'];
        }

        // Kiểm tra OTP có hết hạn không
        if (Carbon::parse($customer->email_otp_expires_at)->isPast()) {
            return ['success' => false, 'message' => 'Mã OTP đã hết hạn! Vui lòng yêu cầu gửi lại.'];
        }

        // Xác thực thành công
        $customer->update([
            'email_verified' => 1,
            'email_otp' => null,
            'email_otp_expires_at' => null
        ]);

        return ['success' => true, 'message' => 'Xác thực email thành công!'];
    }
} 