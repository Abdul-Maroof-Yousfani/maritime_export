<?php

namespace App;

use App\Models\Attachement;
use Illuminate\Database\Eloquent\Model;

class ConversionDetail extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'converstion_details';
    protected $guarded = [];


    public function by_product(){
        return $this->hasMany(ConversionByProduct::class, 'converstion_detail_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachement::class, 'model');
    }
}
