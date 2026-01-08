<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class CommodityPurchaseOrder extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = [
        'category_id',
        'product_id',
        'crop_based_id',
        'voucher_no',
        'voucher_date',
        'location_id',
        'req_date',
        'promise_date',
        'party_id',
        'order_rate',
        'rate_per_kg',
        'delivery_term',
        'delivery_mode',
        'comm_term',
        'commision_per_bag',
        'bardana_per_bag',
        'freight_per_traller',
        'qty_traller',
        'qty_truck',
        'qty_bag',
        'qty_kg',
        'qty_katta',
        'po_amount',
        'landed_rate_per_kg',
        'agent_id',
        'transporter_id',
        'status',
        'username',
    ];

    public function getVoucherNoAttribute($value)
    {
        return CommonHelper::getCommodityPOVoucherCodeFormat($value)[0];
    }
    public function getVoucherDateAttribute($value)
    {
        return CommonHelper::changeDateFormat($value);
    }

    public function category()
    {
        return $this->belongsTo(Product::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function cropBased()
    {
        return $this->belongsTo(CropBased::class, 'crop_based_id');
    }
}
