<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachement extends Model
{
    protected $connection ='mysql2';
    public function model()
    {
        return $this->morphTo();
    }
}
