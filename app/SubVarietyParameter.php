<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubVarietyParameter extends Model
{
    protected $connection = "mysql2";
    protected $table = 'sub_variety_parameters';
    protected $guarded = [];


    public function parameter() {
        return $this->belongsTo(SlabType::class,'parameter_id');
    }
}
