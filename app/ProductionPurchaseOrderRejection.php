<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionPurchaseOrderRejection extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'production_purchase_order_rejections';

    protected $fillable = [
        'po_qty',
        'received_qty',
        'rejected_qty',
        'po_unit',
        'rejection_type',
        'rejected_by',
        'po_id',
        'ins_id',
    ];
}
