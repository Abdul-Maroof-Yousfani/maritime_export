<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Subitem::class, 'item_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
