<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceJobLabour extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'maintenance_job_id',
        'labour_description',
        'qty',
        'wage',
        'amount',
    ];
}
