<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrivalInspection extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'arrival_inspections';

    protected $guarded = [];

    public function moisture(){
        return $this->hasOne(InpectionChecklist::class, 'ins_id')->where('type', 2)->where('checker_id',9);
    }

    public function damage(){
        return $this->hasOne(InpectionChecklist::class, 'ins_id')->where('type', 2)->where('checker_id',4);
    }

    public function broken(){
        return $this->hasOne(InpectionChecklist::class, 'ins_id')->where('type', 2)->where('checker_id',5);
    }

    public function chalky(){
        return $this->hasOne(InpectionChecklist::class, 'ins_id')->where('type', 2)->where('checker_id',12);
    }

    public function chobba(){
        return $this->hasOne(InpectionChecklist::class, 'ins_id')->where('type', 2)->where('checker_id',15);
    }
    public function look(){
        return $this->hasOne(InpectionChecklist::class, 'ins_id')->where('type', 2)->where('checker_id',16);
    }
    public function o_v(){
        return $this->hasOne(InpectionChecklist::class, 'ins_id')->where('type', 2)->where('checker_id',17);
    }


    public function moisture1(){
        return $this->hasOne(InspectionParameter::class, 'ins_id')->where('parameter_id',9);
    }

    public function damage1(){
        return $this->hasOne(InspectionParameter::class, 'ins_id')->where('parameter_id',4);
    }

    public function broken1(){
        return $this->hasOne(InspectionParameter::class, 'ins_id')->where('parameter_id',5);
    }

    public function chalky1(){
        return $this->hasOne(InspectionParameter::class, 'ins_id')->where('parameter_id',12);
    }

    public function chobba1(){
        return $this->hasOne(InspectionParameter::class, 'ins_id')->where('parameter_id',15);
    }
    public function look1(){
        return $this->hasOne(InspectionParameter::class, 'ins_id')->where('parameter_id',16);
    }
    public function o_v1(){
        return $this->hasOne(InspectionParameter::class, 'ins_id')->where('parameter_id',17);
    }
}
