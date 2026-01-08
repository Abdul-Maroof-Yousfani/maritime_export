<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation_Data extends Model{
    protected $table = 'quotation_data';
    protected $connection = 'mysql2';
    protected $guarded = [];
    // protected $fillable = [
    //     "master_id",
    //     "voucher_no",
    //     "pr_id",
    //     "pr_data_id",
    //     "rate",
    //     "amount",
    //     "quotation_status",
    //     "vendor"
    // ];
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function demandData()
    {
        return $this->belongsTo(DemandData::class,'pr_data_id','id','demand_data');
    }


}
