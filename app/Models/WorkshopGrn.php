<?php

namespace App\Models;

use App\CompanyLocation;
use Illuminate\Database\Eloquent\Model;

class WorkshopGrn extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    /**
     * Get the maintenanceJob that owns the WorkshopGrn
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maintenanceJob()
    {
        return $this->belongsTo(MaintenanceJob::class, 'maintenance_job_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(CompanyLocation::class, 'location_id', 'id');
    }

    public function gatepass()
    {
        return $this->belongsTo(GatePass::class, 'gate_pass_id', 'id');
    }

    /**
     * Get all of the itemData for the WorkshopGrn
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    
    public function itemData()
    {
        return $this->hasMany(WorkshopGrnData::class, 'workshop_grn_id', 'id')->where('status',1);
    }
    
    public function comments()
    {
        return $this->morphMany(Attachement::class, 'model');
    }
}
