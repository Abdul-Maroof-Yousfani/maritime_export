<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingListData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'packing_list_datas';

    protected $fillable = [
        'packing_list_id',
        'commercial_invoice_data_id',
        'item_id',
        'description',
        'grade_size',
        'total_cartons',
        'total_net_kgs',
        'total_gross_kgs',
        'status'
    ];

    public function packingList()
    {
        return $this->belongsTo(PackingList::class, 'packing_list_id');
    }

    public function commercialInvoiceData()
    {
        return $this->belongsTo(CommercialInvoiceData::class, 'commercial_invoice_data_id');
    }

    public function item()
    {
        return $this->belongsTo(Subitem::class, 'item_id');
    }
}
