<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversionByProduct extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'converstion_by_products';
    protected $guarded = [];
}
