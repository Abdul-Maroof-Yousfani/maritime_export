<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopMaterialIssuanceData extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public function subItem()
    {
        return $this->belongsTo(Subitem::class, 'item_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(SubDepartment::class, 'department_id', 'id');
    }
    public function grnData()
    {
        return $this->belongsTo(WorkshopGrnData::class, 'grn_data_id', 'id');
    }
}
