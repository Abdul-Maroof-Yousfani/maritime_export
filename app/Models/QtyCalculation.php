<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QtyCalculation extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'traller',
        'traller_from',
        'traller_to',
        'truck',
        'truck_from',
        'truck_to',
        'bag',
        'bag_from',
        'bag_to',
        'kg',
        'kg_from',
        'kg_to',
        'katta',
        'katta_from',
        'katta_to',
        'username',
    ];
}
