<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReturn extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'maintenance_job_id',
        'department_id',
        'voucher_no',
        'voucher_date',
        'location_id',
        'sender_name',
        'return_date',
        'contact_person',
        'description',
        'status',
        'voucher_status',
        'username',
    ];

    public function department() {
        return $this->belongsTo(SubDepartment::class, 'department_id', 'id');
    }
    public function warehouse() {
        return $this->belongsTo(Warehouse::class, 'location_id', 'id');
    }
    
    public function maintenanceJob(){
        return $this->belongsTo(MaintenanceJob::class, 'maintenance_job_id', 'id');
    }

    /**
     * Get all of the returnData for the GoodsReturn
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returnData()
    {
        return $this->hasMany(GoodsReturnData::class, 'goods_return_id', 'id');
    }
}
