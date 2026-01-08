<?php

namespace App;

use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Model;

class GatePassReturnableData extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(SubDepartment::class, 'department_id', 'id');
    }
}
