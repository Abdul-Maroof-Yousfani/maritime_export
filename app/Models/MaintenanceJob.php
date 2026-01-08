<?php

namespace App\Models;

use App\CompanyLocation;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJob extends Model
{
    //
    protected $connection = "mysql2";

    protected $fillable = [
        'maintenance_request_id',
        'voucher_no',
        'voucher_date',
        'description',
        'username',
        'voucher_status',
        'status',
        'job_type',
        'supplier_id',
        'warehouse_id',
        'warehouse_id_to',
    ];

    

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'maintenance_request_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
    public function companyLocation()
    {
        return $this->belongsTo(CompanyLocation::class, 'warehouse_id', 'id');
    }
    public function companyLocationTo()
    {
        return $this->belongsTo(CompanyLocation::class, 'warehouse_id_to', 'id');
    }


    public function jobData()
    {
        return $this->hasMany(MaintenanceJobData::class, 'maintenance_job_id', 'id')->where('status', 1);
    }

    public function labourData()
    {
        return $this->hasMany(MaintenanceJobLabour::class, 'maintenance_job_id', 'id'); // ->where('status', 1);
    }

    /**
     * Get the maintenanceInvoice associated with the MaintenanceJob
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maintenanceInvoice()
    {
        return $this->hasOne(MaintenanceInvoice::class, 'maintenance_job_id', 'id')->where('status', 1);
    }

    public function gatePassIn()
    {
        return $this->hasOne(GatePass::class, 'maintenance_job_id', 'id')->where('status', 1)->where('gate_pass_type', 1);
    }
    
    public function gatePassOut()
    {
        // dd(request()->warehouse_id, $this->hasOne(GatePass::class, 'maintenance_job_id', 'id')->where('status', 1)->where('gate_pass_type', 2)->where('location_id', request()->warehouse_id)->get());
        return $this->hasOne(GatePass::class, 'maintenance_job_id', 'id')->where('status', 1)->where('gate_pass_type', 2)->where('location_id', request()->warehouse_id);
    }
    public function gatePassOutNotComplete()
    {
        return $this->hasOne(GatePass::class, 'maintenance_job_id', 'id')->where('voucher_status', 2)->where('status', 1)->where('gate_pass_type', 2)->where('is_complete', '!=', 1);
    }
    public function gatePassInWithRequestedLocation()
    {
        // dd(request()->warehouse_id);
        return $this->hasOne(GatePass::class, 'maintenance_job_id', 'id')->where('status', 1)->where('gate_pass_type', 1)->where('location_id', request()->warehouse_id);
    }
    public function grn()
    {
        return $this->hasOne(WorkshopGrn::class, 'maintenance_job_id', 'id')->where('status', 1);
    }

    public function comments()
    {
        return $this->morphMany(Attachement::class, 'model'); 
    }

    public function inhouseDontHaveIssuance(){
        return $this->hasOne(WorkshopMaterialIssuance::class, 'maintenance_job_id', 'id')->where('status', 1);
    }
}
