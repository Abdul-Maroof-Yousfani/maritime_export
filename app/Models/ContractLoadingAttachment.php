<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractLoadingAttachment extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'contract_loading_attachments';
    
    protected $fillable = [
        'contract_loading_id',
        'file_name',
        'original_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'status'
    ];

    /**
     * Get the contract loading that owns the attachment.
     */
    public function contractLoading()
    {
        return $this->belongsTo(ContractLoading::class, 'contract_loading_id');
    }
}

