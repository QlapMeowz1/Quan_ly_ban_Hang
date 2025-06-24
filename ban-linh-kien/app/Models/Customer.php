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
        'date_of_birth', 'gender', 'status', 'email_verified', 'user_id',
        'email_otp', 'email_otp_expires_at', 'phone_otp'
    ];
    protected $casts = [
        'email_verified' => 'boolean',
        'date_of_birth' => 'date',
        'email_otp_expires_at' => 'datetime',
    ];
    public $timestamps = false;

    
    public function hasVerifiedEmail()
    {
        return true;
    }

 
    public function markEmailAsVerified()
    {
        $this->update([
            'email_verified' => 1,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
