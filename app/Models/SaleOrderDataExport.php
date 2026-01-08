<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrderDataExport extends Model
{
    protected $connection = "mysql2";

    public function item() {
        return $this->belongsTo(Subitem::class, 'item_id', 'id');
    }
}
