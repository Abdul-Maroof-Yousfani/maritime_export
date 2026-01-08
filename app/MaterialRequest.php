<?php

namespace App;

use App\Models\Line;
use App\Models\Machinery;
use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];
    public function material_request_data(){
        return $this->hasMany(MaterialRequestData::class, 'material_request_id')->where('status', 1);
    }

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

    public function company_location()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }
}
