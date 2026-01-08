<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model{
    protected $table = 'stock';
    protected $connection = 'mysql2';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
