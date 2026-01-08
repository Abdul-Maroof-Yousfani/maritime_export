<?php

namespace App\Models;

use App\CompanyLocation;
use App\Models\Attachement;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model{
    protected $table = 'demand';
    protected $connection = 'mysql2';
    protected $guarded = [];
    // protected $fillable = ['slip_no','demand_no','demand_date','sub_department_id','description','demand_status','status','date','time','username','approve_username','delete_username'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    

    public function department(){
        return $this->belongsTo(SubDepartment::class,'sub_department_id','id');
    }

    public function comments()
    {
        return $this->morphMany(Attachement::class, 'model');
    }
    
    public function company_location()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }
}
