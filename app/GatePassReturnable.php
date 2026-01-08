<?php

namespace App;

use App\Models\Attachement;
use Illuminate\Database\Eloquent\Model;

class GatePassReturnable extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    public function returnable_data(){
        return $this->hasMany(GatePassReturnableData::class, 'gate_pass_returnables_id')->where('status', 1);
    }
    
    public function attachments()
    {
        return $this->morphMany(Attachement::class, 'model');
    }

    public function company_location()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }
}
