<?php

namespace App\Models;

use App\MaterialRequest;
use Illuminate\Database\Eloquent\Model;

class Issuance extends Model{
    protected $connection ='mysql2';
    protected $table = 'issuance';
    // protected $fillable = ['iss_no','iss_date','description','status','created_date'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function issuence_datas()
    {
        return $this->hasMany(IssuanceData::class, 'master_id')->where('status',1);
    }

    public function machine()
    {
        return $this->belongsTo(Machinery::class, 'machine_id');
    }

    public function material()
    {
        return $this->belongsTo(MaterialRequest::class, 'material_id');
    }


    public function department()
    {
        return $this->belongsTo(SubDepartment::class, 'department_id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class, 'line_id');
    }
}
