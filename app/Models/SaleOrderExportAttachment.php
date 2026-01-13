<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrderExportAttachment extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'sale_order_export_attachments';
    
    protected $fillable = [
        'sale_order_export_id',
        'file_name',
        'original_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'status'
    ];

    /**
     * Get the sale order export that owns the attachment.
     */
    public function saleOrderExport()
    {
        return $this->belongsTo(SaleOrderExport::class, 'sale_order_export_id');
    }
}

