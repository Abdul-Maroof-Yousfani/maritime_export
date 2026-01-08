<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    
    protected $connection = "mysql2";

    
    public function Correspondent()
    {
        return $this->hasOne(Bank::class, 'beneficiary_id');
    }
}
