<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'packing_lists';

    protected $fillable = [
        'commercial_invoice_id',
        'packing_list_no',
        'invoice_no',
        'date',
        'gd_no',
        'container_no',
        'consignee_name',
        'consignee_address',
        'vessel_voyage',
        'port_from',
        'port_to',
        'payment_term',
        'gross_weight',
        'status'
    ];

    public function commercialInvoice()
    {
        return $this->belongsTo(CommercialInvoice::class, 'commercial_invoice_id');
    }

    public function packingListData()
    {
        return $this->hasMany(PackingListData::class, 'packing_list_id')->where('status', 1);
    }
}
