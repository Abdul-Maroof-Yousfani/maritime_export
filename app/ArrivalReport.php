<?php

namespace App;

use App\Models\Attachement;
use Illuminate\Database\Eloquent\Model;

class ArrivalReport extends Model
{
    protected $connection = 'mysql2';
    protected $guarded = [];

    public function company_location()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }

    public function arrival_report(){
        return $this->hasMany(ArrivalReportData::class, 'arrival_report_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachement::class, 'model');
    }
}
