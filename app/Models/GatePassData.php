<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatePassData extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    /** Relationships */
    public function subItem(){
        return $this->belongsTo(Subitem::class, 'item_id');
    }
}
