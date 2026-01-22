<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractLoadingData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'contract_loading_datas';

    protected $fillable = [
        'contract_loading_id',
        'sale_order_data_export_id',
        'item_id',
        'layer',
        'qty',
        'status'
    ];

    public function contractLoading()
    {
        return $this->belongsTo(ContractLoading::class, 'contract_loading_id');
    }

    public function saleOrderDataExport()
    {
        return $this->belongsTo(SaleOrderDataExport::class, 'sale_order_data_export_id');
    }
}

