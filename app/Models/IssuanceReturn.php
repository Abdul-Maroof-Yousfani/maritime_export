<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuanceReturn extends Model
{
    protected $connection ='mysql2';
    protected $guarded = [];

    public function issuence_return_datas()
    {
        return $this->hasMany(IssuanceReturnData::class, 'issuance_return_id')->where('status',1);
    }

    public function machine()
    {
        return $this->belongsTo(Machinery::class, 'machine_id');
    }

    public function department()
    {
        return $this->belongsTo(SubDepartment::class, 'department_id');
    }

    public function line()
    {
        return $this->belongsTo(line::class, 'line_id');
    }
}
