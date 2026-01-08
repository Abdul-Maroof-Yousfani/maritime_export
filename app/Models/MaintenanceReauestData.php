<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceReauestData extends Model
{
    protected $fillable = [
        'maintenance_request_id',
        'item_id',
        'qty',
        'status',
    ];
    protected $connection = "mysql2";

    /**
     * Get the subItem that owns the MaintenanceReauestData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subItem()
    {
        return $this->belongsTo(Subitem::class, 'item_id', 'id');
    }
}
