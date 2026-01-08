<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectionPurhaseOrderData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'inspection_purchase_order_datas';

    protected $fillable = [
        'po_no',
        'ins_no',
        'total_qty',
        'balance_qty',
        'recived_qty',
        'reject_qty',
    ];
}
