<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandData extends Model{
    protected $table = 'demand_data';
    protected $connection = 'mysql2';
    protected $guarded = [];
    // protected $fillable = ['demand_no','demand_date','category_id','sub_item_id','description','qty','demand_status','status','date','time','username','approve_username','delete_username'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function demand(){
        return $this->belongsTo(Demand::class,'master_id','id');
    }

    public function subItem(){
        return $this->belongsTo(Subitem::class,'sub_item_id','id');
    }
}
