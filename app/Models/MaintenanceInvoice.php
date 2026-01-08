<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceInvoice extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'voucher_no',
        'voucher_date',
        'labour_hour',
        'labour_wage',
        'maintenance_job_id',
        'voucher_status',
        'username',
        'completion_date',
        'instruct_by',
        'completed_by',
        'department_id',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(SubDepartment::class, 'department_id', 'id');
    }


    /**
     * Get the maintenanceJob that owns the MaintenanceInvoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maintenanceJob()
    {
        return $this->belongsTo(MaintenanceJob::class, 'maintenance_job_id', 'id');
    }

    /**
     * Get all of the invoiceData for the MaintenanceInvoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoiceData()
    {
        return $this->hasMany(MaintenanceInvoiceData::class, 'maintenance_invoice_id', 'id');
    }
}
