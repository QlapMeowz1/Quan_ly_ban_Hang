<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'image_id';
    protected $fillable = ['product_id', 'image_url', 'image_alt', 'is_primary', 'sort_order'];
    public $timestamps = false;
}
