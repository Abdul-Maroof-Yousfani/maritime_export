<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public $timestamps = false;
}
