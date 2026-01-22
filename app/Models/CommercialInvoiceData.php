<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialInvoiceData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'commercial_invoice_datas';

    protected $fillable = [
        'commercial_invoice_id',
        'sale_order_data_export_id',
        'item_id',
        'description',
        'grade_size',
        'total_cartons',
        'total_net_kgs',
        'rate_cfr_per_kg',
        'amount_usd',
        'status'
    ];

    public function commercialInvoice()
    {
        return $this->belongsTo(CommercialInvoice::class, 'commercial_invoice_id');
    }

    public function saleOrderDataExport()
    {
        return $this->belongsTo(SaleOrderDataExport::class, 'sale_order_data_export_id');
    }

    public function item()
    {
        return $this->belongsTo(Subitem::class, 'item_id');
    }
}

