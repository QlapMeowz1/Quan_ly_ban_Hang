<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'site_settings';
    protected $primaryKey = 'setting_id';
    public $timestamps = false;
    protected $fillable = [
        'setting_key', 'setting_value', 'setting_type', 'description', 'updated_at'
    ];
} 