<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesOrderGatePass extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];
}
