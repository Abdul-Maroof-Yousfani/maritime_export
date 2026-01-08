<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportBillOfLading extends Model
{
    protected $connection = "mysql2";

    public function bol_notify(){
        return $this->hasMany(ExportBolNotify::class , 'bol_id' , 'id');
    }
}
