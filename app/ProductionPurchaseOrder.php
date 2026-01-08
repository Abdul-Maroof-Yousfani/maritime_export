<?php

namespace App;

use App\Helpers\CommonHelper;
use App\Models\Attachement;
use App\Models\CropBased;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductionPurchaseOrder extends Model
{
    protected $connection = 'mysql2';
    protected $guarded = [];

    public function company_location()
    {
        return $this->belongsTo(CompanyLocation::class, 'location_id');
    }

    public function getVoucherDateAttribute($value)
    {
        return CommonHelper::changeDateFormat($value);
    }

    public function category()
    {
        return $this->belongsTo(Product::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Product::class, 'sub_category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function subitem()
    {
        return $this->belongsTo(Product::class, 'subitem_id');
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }
    
    public function cropBased()
    {
        return $this->belongsTo(CropBased::class, 'crop_based_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachement::class, 'model');
    }

}
