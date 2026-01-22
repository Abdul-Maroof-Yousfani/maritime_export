<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractLoading extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'contract_loadings';

    protected $fillable = [
        'loading_no',
        'sale_order_export_id',
        'contract_no',
        'loading_date',
        'vehicle_no',
        'name',
        'container_no',
        'seal_no',
        'status'
    ];

    public function saleOrderExport()
    {
        return $this->belongsTo(SaleOrderExport::class, 'sale_order_export_id');
    }

    public function loadingData()
    {
        return $this->hasMany(ContractLoadingData::class, 'contract_loading_id');
    }

    public function attachments()
    {
        return $this->hasMany(ContractLoadingAttachment::class, 'contract_loading_id')->where('status', 1);
    }

    public function containers()
    {
        return $this->hasMany(ContractLoadingContainer::class, 'contract_loading_id')->where('status', 1);
    }

    public function vehicles()
    {
        return $this->hasMany(ContractLoadingVehicle::class, 'contract_loading_id')->where('status', 1);
    }
}

