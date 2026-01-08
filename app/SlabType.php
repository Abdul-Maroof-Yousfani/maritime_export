<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlabType extends Model
{
    protected $connection = "mysql2";
    protected $fillable =[
        'name',
        'username',
        'status',
        'date',
    ];
}
