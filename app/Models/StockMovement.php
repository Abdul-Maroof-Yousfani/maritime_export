<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'item_id',
        'type_id',
        'warehouse_id',
        'username',
        'status',
    ];
}
