<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrivalReportData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'arrival_report_datas';
    protected $guarded = [];
}
