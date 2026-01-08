<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyzingReportDetail extends Model
{
    protected $connection = "mysql2";
    protected $table = 'analyzing_mr';
    protected $guarded = [];
    public $timestamps = false;

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'maintenance_request_id', 'id');
    }

    public function analyzingReportDetailData()
    {
        return $this->hasMany(AnalyzingReportDetailData::class, 'analyzing_mr_id', 'id')->where('status', 1);
    }
}
