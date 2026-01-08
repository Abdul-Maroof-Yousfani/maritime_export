<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReverseLog extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];
    // protected $fillable = ['username', 'supplier_id', 'quotation_data_id'];
}
