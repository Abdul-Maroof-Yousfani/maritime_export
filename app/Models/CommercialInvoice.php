<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialInvoice extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'commercial_invoices';

    protected $fillable = [
        'contract_loading_id',
        'sale_order_export_id',
        'invoice_no',
        'invoice_date',
        'gd_no',
        'container_no',
        'consignee_name',
        'consignee_address',
        'vessel_voyage',
        'port_from',
        'port_to',
        'payment_term',
        'grand_total',
        'advance_amount',
        'balance_amount',
        'currency_id',
        'exchange_rate',
        'status'
    ];

    public function contractLoading()
    {
        return $this->belongsTo(ContractLoading::class, 'contract_loading_id');
    }

    public function saleOrderExport()
    {
        return $this->belongsTo(SaleOrderExport::class, 'sale_order_export_id');
    }

    public function invoiceData()
    {
        return $this->hasMany(CommercialInvoiceData::class, 'commercial_invoice_id')->where('status', 1);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}

