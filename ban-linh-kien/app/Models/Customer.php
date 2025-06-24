<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'username', 'email', 'password_hash', 'first_name', 'last_name', 'phone',
        'date_of_birth', 'gender', 'status', 'email_verified', 'email_otp', 
        'email_otp_expires_at', 'user_id'
    ];
    protected $casts = [
        'email_verified' => 'boolean',
        'email_otp_expires_at' => 'datetime',
        'date_of_birth' => 'date',
    ];
    public $timestamps = false;

    /**
     * Generate and save email OTP
     */
    public function generateEmailOTP()
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $this->update([
            'email_otp' => $otp,
            'email_otp_expires_at' => Carbon::now()->addMinutes(10), // OTP hết hạn sau 10 phút
        ]);
        
        return $otp;
    }

    /**
     * Verify email with OTP
     */
    public function verifyEmailOTP($otp)
    {
        if (!$this->email_otp || !$this->email_otp_expires_at) {
            return false;
        }

        if (Carbon::now()->isAfter($this->email_otp_expires_at)) {
            return false; // OTP đã hết hạn
        }

        if ($this->email_otp !== $otp) {
            return false; // OTP không đúng
        }

        // Xác thực thành công
        $this->update([
            'email_verified' => true,
            'email_otp' => null,
            'email_otp_expires_at' => null,
        ]);

        return true;
    }

    /**
     * Check if email OTP is expired
     */
    public function isEmailOTPExpired()
    {
        if (!$this->email_otp_expires_at) {
            return true;
        }

        return Carbon::now()->isAfter($this->email_otp_expires_at);
    }

    /**
     * Check if email is verified
     */
    public function hasVerifiedEmail()
    {
        return $this->email_verified;
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified()
    {
        $this->update([
            'email_verified' => true,
            'email_otp' => null,
            'email_otp_expires_at' => null,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
