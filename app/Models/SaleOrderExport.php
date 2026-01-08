<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrderExport extends Model
{
    protected $connection = "mysql2";

    public function getModeOfTransportAttribute(){
        $value = $this->mode_transport;
        $output = '';
        switch ($value) {
            case 1:
                $output = 'By Sea';
                break;
            case 2:
                $output = 'By Air';
                break;
            case 3:
                $output = 'By Road';
                break;
        }
        return $output;
    }

    /**
     * Get all of the exportOrderData for the SaleOrderExport
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exportOrderData()
    {
        return $this->hasMany(SaleOrderDataExport::class, 'sale_order_export_id', 'id')->where('status', 1);
    }
    
    public function consigneeData()
    {
        return $this->hasMany(ExportOrderConsignee::class, 'export_order_id', 'id');
    }
    public function notifyData()
    {
        return $this->hasMany(ExportOrderNotify::class, 'export_order_id', 'id');
    }

}
