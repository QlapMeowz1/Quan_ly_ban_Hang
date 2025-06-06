<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'username', 'email', 'password_hash', 'first_name', 'last_name', 'phone',
        'date_of_birth', 'gender', 'status', 'email_verified', 'phone_verified', 'user_id'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
