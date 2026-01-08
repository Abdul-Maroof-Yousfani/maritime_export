<?php

namespace App;

use App\Models\Line;
use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Model;

class ScrapDeclration extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public function ScrapData()
    {
        return $this->hasMany(ScrapDeclrationData::class, 'scrap_declration_id');
    }

    public function department()
    {
        return $this->belongsTo(SubDepartment::class, 'department_id', 'id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class, 'line_no', 'id');
    }

    public function company_location()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }

    
}
