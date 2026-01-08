<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReturnData extends Model
{
    protected $connection = "mysql2";

    protected $fillable = [
        'goods_return_id',
        'item_id',
        'quality_type',
        'qty',
        'rate',
        'total',
        'item_remark',
        'status',
    ];

    /**
     * Get the subItem that owns the GoodsReturnData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subItem()
    {
        return $this->belongsTo(Subitem::class, 'item_id', 'id');
    }
}
