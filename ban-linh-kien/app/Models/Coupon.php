<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $primaryKey = 'coupon_id';
    protected $fillable = [
        'coupon_code', 'coupon_name', 'discount_type', 'discount_value',
        'minimum_order_amount', 'maximum_discount_amount', 'usage_limit',
        'used_count', 'valid_from', 'valid_until', 'status'
    ];
    public $timestamps = false;
} 