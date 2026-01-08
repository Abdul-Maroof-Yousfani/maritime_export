<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Slab extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = [
        'slab_type_id',
        'product_id',
        'from',
        'to',
        'amount',
        'remark',
        'status',
        'date',
        'username',
    ];

    public function slab_type()
    {
        return $this->belongsTo(SlabType::class,'slab_type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
