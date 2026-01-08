<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopMaterialIssuance extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    /**
     * Get all of the itemData for the WorkshopMaterialIssuance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemData()
    {
        return $this->hasMany(WorkshopMaterialIssuanceData::class, 'workshop_material_issuance_id', 'id')->where('status', 1);
    }

    public function maintenanceJob()
    {
        return $this->belongsTo(MaintenanceJob::class, 'maintenance_job_id', 'id');
    }
}
