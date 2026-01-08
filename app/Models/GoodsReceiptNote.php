<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptNote extends Model{
    protected $table = 'goods_receipt_note';
    protected $connection = 'mysql2';
    protected $guarded = [];
    // protected $fillable = ['store_control_no','temp_grn_id','grn_no','grn_date','pr_no','pr_date','sub_department_id','supplier_id','main_description','invoice_no','status','grn_status','username','date','time','approve_username','delete_username'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class,'po_no','purchase_request_no');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachement::class, 'model');
    }
}
