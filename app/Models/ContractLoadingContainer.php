<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractLoadingContainer extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'contract_loading_containers';

    protected $fillable = [
        'contract_loading_id',
        'container_no',
        'seal_no',
        'status'
    ];

    public function contractLoading()
    {
        return $this->belongsTo(ContractLoading::class, 'contract_loading_id');
    }
}

