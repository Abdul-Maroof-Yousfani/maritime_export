<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopGrnData extends Model
{
    protected $connection = "mysql2";
    protected $guarded = [];

    /**
     * Get the subItem that owns the WorkshopGrnData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function subItem()
    {
        return $this->belongsTo(Subitem::class, 'item_id', 'id');
    }
    public function grn()
    {
        return $this->belongsTo(WorkshopGrn::class, 'workshop_grn_id', 'id');
    }
}
