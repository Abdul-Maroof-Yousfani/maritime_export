<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportPakingList extends Model
{
    protected $connection = "mysql2";

    public function invoice(){
        return $this->belongsTo(ExportInvoice::class, 'invoice_id');
    }
    public function packingListData(){
        return $this->hasMany(ExportPakingListData::class, 'import_paking_list_id');
    }
    
}
