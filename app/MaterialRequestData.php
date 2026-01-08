<?php

namespace App;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Model;

class MaterialRequestData extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
}
