<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceInvoiceData extends Model
{
    protected $connection = "mysql2";
    protected $fillable = [
        'maintenance_invoice_id',
        'item_id',
        'qty',
        'rate',
        'total',
        'return_qty',
    ];

    /**
     * Get the subItem that owns the MaintenanceInvoiceData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subItem()
    {
        return $this->belongsTo(Subitem::class, 'item_id', 'id');
    }
}
