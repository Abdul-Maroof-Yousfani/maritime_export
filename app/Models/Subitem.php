<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subitem extends Model{
    protected $connection ='mysql2';

	protected $table = 'subitem';
	protected $fillable = ['supplier_id','sub_ic','scientific_name','main_ic_id','acc_id','department_id','pack_size','kit_amount','tax_able','sales_tax_rate','time','date','action','username','status','trail_id','branch_id','type','no_test','uom','saleOutUnitQuantityPrice','allowDiscountUnitQuantity','completeBoxPrice','completeBoxDiscount','allowTestingQuantity','inventoryStockEveryTime','totalQuantityinOnePack','stockType','itemType','hs_code'];
	protected $primaryKey = 'id';
	public $timestamps = false;

	public function category()
	{
		return $this->belongsTo(Category::class,'main_ic_id','id');
	}
	public function uomData()
	{
		return $this->belongsTo(UOM::class,'uom','id');
	}
	public function packUom()
	{
		return $this->belongsTo(UOM::class,'pack_uom','id');
	}

	public function demand_type()
	{
		return $this->belongsTo(DemandType::class,'type','id');
	}
}
