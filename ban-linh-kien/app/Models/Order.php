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

    public $timestamps = false;

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
            'pending' => 'Đã đặt',
            'confirmed' => 'Đã lên đơn',
            'processing' => 'Đã lên đơn',
            'shipping' => 'Đang vận chuyển',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy',
            'returned' => 'Đã trả hàng',
        ];
        return $map[$this->order_status] ?? $this->order_status;
    }
}
