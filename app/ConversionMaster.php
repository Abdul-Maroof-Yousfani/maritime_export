<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversionMaster extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'converstion_masters';
    protected $guarded = [];


    public function conversion_detail(){
        return $this->hasMany(ConversionDetail::class, 'converstion_master_id');
    }
}
