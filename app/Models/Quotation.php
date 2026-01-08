<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model{
    protected $connection = 'mysql2';
    protected $table = 'quotation';
    // protected $fillable = [
    //     'pr_id',
    //     'pr_no',
    //     'voucher_no',
    //     'voucher_date',
    //     'vendor_id',
    //     'date',
    //     'status',
    //     'username',
    //     'ref_no'
    // ];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function comments()
    {
        return $this->morphMany(Attachement::class, 'model')->where('status', 1);
    }
    

    public function quotationDatas()
    {
        return $this->hasMany(Quotation_Data::class, 'master_id','id');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation_Data::class, 'master_id','id');
    }

}
