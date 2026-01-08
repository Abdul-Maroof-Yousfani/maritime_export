<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportInvoice extends Model
{
    protected $connection = "mysql2";
    public function exportOrder(){
        return $this->belongsTo(SaleOrderExport::class, 'sale_order_export_id');
    }
    public function proforma(){
        return $this->belongsTo(ExportPerforma::class, 'proforma_id');
    }
    public function invoiceData(){
        return $this->hasOne(ExportInvoiceData::class, 'export_invoice_id');
    }
    public function itemData(){
        return $this->hasMany(ExportInvoiceData::class, 'export_invoice_id')->where('status', 1);
    }
    
    public function notify(){
        return $this->hasMany(ExportCommercialNotifyAddress::class, 'commercial_invoice_id')->where('status', 1);
    }
}
