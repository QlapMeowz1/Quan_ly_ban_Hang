<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Notifications\EmailVerificationOTP;
use Illuminate\Console\Command;

class TestEmailVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email-verification {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email verification system by sending OTP to specified email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("🧪 Testing Email Verification System");
        $this->info("📧 Target Email: {$email}");
        $this->line("");

        // Check if customer exists
        $customer = Customer::where('email', $email)->first();
        
        if (!$customer) {
            $this->error("❌ Customer with email {$email} not found!");
            $this->info("💡 Create a customer first or use existing email from database");
            return 1;
        }

        $this->info("✅ Customer found: {$customer->email}");
        
        // Check current verification status
        if ($customer->hasVerifiedEmail()) {
            $this->warn("⚠️  Email is already verified!");
            
            if (!$this->confirm("Do you want to reset verification status and send new OTP?")) {
                return 0;
            }
            
            // Reset verification status
            $customer->update([
                'email_verified' => false,
                'email_otp' => null,
                'email_otp_expires_at' => null,
            ]);
            
            $this->info("🔄 Reset verification status");
        }

        // Generate OTP
        $this->info("🔢 Generating OTP...");
        $otp = $customer->generateEmailOTP();
        $this->info("✅ OTP Generated: {$otp}");
        $this->info("⏰ Expires at: {$customer->email_otp_expires_at}");

        // Send email
        $this->info("📤 Sending email notification...");
        
        try {
            $customer->notify(new EmailVerificationOTP($otp));
            $this->info("✅ Email sent successfully!");
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            return 1;
        }

        $this->line("");
        $this->info("🎯 Test Results:");
        $this->table(
            ['Field', 'Value'],
            [
                ['Customer ID', $customer->customer_id],
                ['Email', $customer->email],
                ['OTP Code', $otp],
                ['Expires At', $customer->email_otp_expires_at],
                ['Verified', $customer->email_verified ? 'Yes' : 'No'],
            ]
        );

        $this->line("");
        $this->info("🔗 Next Steps:");
        $this->line("1. Check your email inbox for the OTP");
        $this->line("2. Visit: " . route('email.verify.show', ['email' => $email]));
        $this->line("3. Enter the OTP: {$otp}");
        $this->line("");
        
        // Test verification
        if ($this->confirm("Do you want to test OTP verification now?")) {
            $inputOtp = $this->ask("Enter the OTP to verify");
            
            if ($customer->verifyEmailOTP($inputOtp)) {
                $this->info("✅ OTP Verification Successful!");
                $this->info("🎉 Email is now verified!");
            } else {
                if ($customer->isEmailOTPExpired()) {
                    $this->error("❌ OTP has expired!");
                } else {
                    $this->error("❌ Invalid OTP!");
                }
            }
        }

        return 0;
    }
}
