<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionGatePassIn extends Model
{
    protected $connection = "mysql2";
    protected $table = 'production_get_pass';
    protected $guarded = [];
}
