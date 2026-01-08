<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModeOfTransport extends Model
{
    use SoftDeletes;
    protected $connection = "mysql2";
}
