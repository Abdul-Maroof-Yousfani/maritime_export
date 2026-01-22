<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractLoadingVehicle extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'contract_loading_vehicles';

    protected $fillable = [
        'contract_loading_id',
        'vehicle_no',
        'name',
        'status'
    ];

    public function contractLoading()
    {
        return $this->belongsTo(ContractLoading::class, 'contract_loading_id');
    }
}

