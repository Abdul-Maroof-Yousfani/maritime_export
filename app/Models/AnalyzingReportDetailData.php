<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyzingReportDetailData extends Model
{
    protected $connection = "mysql2";
    protected $table = 'analyzing_mr_data';
    protected $guarded = [];
    public $timestamps = false;
}
