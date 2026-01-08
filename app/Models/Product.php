<?php

namespace App\Models;

use App\SubVarietyParameter;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $connection = 'mysql2';
    protected $table = 'product';
    protected $fillable = [
        'parent_id',
        'name',
        'sku_code',
        'product_type',
        'variety_type',
        'brand',
        'crop_based',
        'uom_id',
        'table_type',
        'type_id',
        'packing_type',
        'packing_size',
        'min_stock',
        'max_stock',
        'status',
        'date',	
        'username',
        'qc_id',
        'sub_variety_type',
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    public function new_category()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id')->whereNull('parent_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id')->whereNotNull('parent_id')->where('table_type',1);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id')->whereNotNull('parent_id')->where('table_type',2);
    }

    public function sub_item()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id')->whereNotNull('parent_id')->where('table_type',3);
    }

    public function fg_parent()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id')->whereNotNull('parent_id')->where('table_type',2);
    }

    public function parameters()
    {
        return $this->hasMany(SubVarietyParameter::class, 'sub_variety_id');
    }

    public function parameter()
    {
        return $this->hasOne(SubVarietyParameter::class, 'sub_variety_id');
    }



    // Parent relationship to get the parent of the current item
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

}
