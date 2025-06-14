<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    
    protected $fillable = [
        'order_number', 'customer_id', 'order_status', 'payment_status', 'payment_method',
        'subtotal', 'shipping_fee', 'discount_amount', 'total_amount', 'coupon_id',
        'shipping_address', 'billing_address', 'notes'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'order_date',
        'payment_date',
        'shipping_date',
        'delivery_date'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'payment_date' => 'datetime',
        'shipping_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'order_id';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function getStatusLabelAttribute()
    {
        $map = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang vận chuyển',
            'delivered' => 'Đã giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'returned' => 'Đã trả hàng',
        ];
        return $map[$this->order_status] ?? $this->order_status;
    }

    public function getPaymentStatusLabelAttribute()
    {
        $map = [
            'pending' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán',
            'refunded' => 'Đã hoàn tiền',
            'failed' => 'Thanh toán thất bại',
            'cancelled' => 'Đã hủy',
        ];
        return $map[$this->payment_status] ?? $this->payment_status;
    }
}
