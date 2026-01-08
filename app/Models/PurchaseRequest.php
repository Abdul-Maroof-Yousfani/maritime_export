<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model{

    protected $connection = "mysql2";
    protected $table = 'purchase_request';
    protected $fillable = ['slip_no','purchase_request_no','purchase_request_date','department_id','supplier_id','description','purchase_request_status','status','date','time','username','approve_username','delete_username'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The purchaseRequestDatas that belong to the PurchaseRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function purchaseRequestDatas()
    {
        return $this->hasMany(PurchaseRequestData::class, 'master_id', 'id');
    }

    public function purchaseRequestasd()
    {
        return $this->hasOne(PurchaseRequestData::class, 'master_id', 'id');
    }
}
