<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceJobData extends Model
{

    protected $connection = "mysql2";
    // protected $table = "maintenance_job_data";

    protected $fillable = [
        'maintenance_job_id',
        'item_id',
        'qty',
        'rate',
        'total',
        'item_description',
        'username',
        'status',
    ];
    public function subItem() {
        return $this->belongsTo(Subitem::class, 'item_id', 'id');
    }
}
