<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'voucher_no',
        'voucher_date',
        'department_id',
        'machine_id',
        'line_id',
        'submit_date',
        'completion_date',
        'warehouse_id',
        'description',
        'username',
        'voucher_status',
        'status',
        'analysing_required',
    ];

    public function department()
    {
        return $this->belongsTo(SubDepartment::class, 'department_id', 'id');
    }
    public function machine()
    {
        return $this->belongsTo(Machinery::class, 'machine_id', 'id');
    }
    public function line()
    {
        return $this->belongsTo(Line::class, 'line_id', 'id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function maintenanceJob()
    {
        return $this->hasMany(MaintenanceJob::class, 'maintenance_request_id', 'id')->where('status', 1)->WhereNotIn('job_type', [1 ,2, 3,4]);
    }

    public function AnalyzingReport()
    {
        return $this->hasMany(AnalyzingReportDetail::class, 'maintenance_request_id', 'id')->where('status', 1);
    }
    public function maintenanceJobInhouseExist()
    {
        return $this->hasOne(MaintenanceJob::class, 'maintenance_request_id', 'id')->where('status', 1)->whereIn('job_type', [1,4]);
    }
    public function maintenanceJobOutsourceExist()
    {
        return $this->hasOne(MaintenanceJob::class, 'maintenance_request_id', 'id')->where('status', 1)->where('job_type', 2);
    }
    public function anotherwarehouse()
    {
        return $this->hasOne(MaintenanceJob::class, 'maintenance_request_id', 'id')->where('status', 1)->where('job_type', 3);
    }
    public function comments()
    {
        return $this->morphMany(Attachement::class, 'model'); 
    }

    /**
     * Get all of the itemData for the MaintenanceRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemData()
    {
        return $this->hasMany(MaintenanceReauestData::class, 'maintenance_request_id', 'id')->where('status', 1);
    }

    public function doesntHaveMjo() {
        return $this->hasMany(MaintenanceJob::class, 'maintenance_request_id', 'id')->where('status', 1);
    }
}
