<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packing extends Model
{
    use SoftDeletes;
    protected $connection = "mysql2";
    protected $fillable = ['name'];
}



