<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    //
    protected $connection = 'mysql';
    public function quotation()
    {
        return $this->belongsToMany('Quotation','company_location_id');
    }
}
