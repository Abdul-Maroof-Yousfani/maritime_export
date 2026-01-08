<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropBased extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'date_from',
        'date_to',
        'status',
        'category_id',
        'username'
    ];

    public function category()
    {
        return $this->belongsTo(Product::class, 'category_id', 'id');
    }
}
