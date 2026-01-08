<?php

namespace App\Models;

use App\CompanyLocation;
use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public function maintenanceJob(){
        return $this->belongsTo(MaintenanceJob::class, 'maintenance_job_id');
    }
    public function parent(){
        return $this->belongsTo(Self::class, 'gatepass_id');
    }

    public function gatePassesData(){
        return $this->hasMany(GatePassData::class, 'gate_pass_id')->where('status', 1);
    }
    public function company_location(){
        return $this->belongsTo(CompanyLocation::class, 'location_id', 'id');
    }

}
