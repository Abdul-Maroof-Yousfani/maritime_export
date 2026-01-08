<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportInvoiceData extends Model
{
    protected $connection = "mysql2";
    public function exportOrderData(){
        return $this->belongsTo(SaleOrderDataExport::class, 'sale_order_export_data_id');
    }
}
