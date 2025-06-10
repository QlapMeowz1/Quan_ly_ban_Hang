<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name', 'product_code', 'category_id', 'brand_id', 'supplier_id',
        'description', 'specifications', 'price', 'cost_price', 'stock_quantity',
        'min_stock_level', 'weight', 'dimensions', 'warranty_period', 'status',
        'featured'
    ];

    /**
     * Get the route key name for Laravel's Route Model Binding.
     */
    public function getRouteKeyName()
    {
        return 'product_id';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id', 'brand_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'product_id');
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
} 