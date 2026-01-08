<?php
namespace App\Helpers;

use App\DemandQuotation;
use App\Models\Demand;
use Illuminate\Support\Facades\DB;

class QuotationHelper
{
  
    public static function get_quotation_amount_supp_wise($demand_data_id,$supplier)
    {
      
         return  DB::Connection('mysql2')->table('quotation as a')
                ->join('quotation_data as b','a.id','=','b.master_id')
                ->where('a.vendor_id',$supplier)
                ->where('b.pr_data_id',$demand_data_id)
                ->select('amount')
                ->value('amount');
    }


    public static function check_quotation_status($type)
    {
        
        $status = 'Pending';

        if ($type==1):
          $status = 'Approved';  
        endif;
        return $status;;
    }
    

    public static function approvedPRForQuotation($company_locations)
    {
      // $company_locations = ReuseableCode::getUserWiseLocationRights();

      return DB::connection('mysql2')->select('SELECT DISTINCT(dd.master_id)
      ,d.id,dd.demand_no,
      dd.demand_complete_status,
      d.company_location_id 
      FROM demand_data as dd
      inner join demand as d on dd.master_id = d.id
      WHERE dd.demand_complete_status = 1 
      and dd.status = 1 
      and dd.cancel_status = 1 
      and d.quotation_skip = 0 
      and d.demand_status = 2 
      and d.status = 1 
      and d.company_location_id = '.$company_locations.' 
      and d.demand_complete_status = 1');
      // return DB::Connection('mysql2')->table('demand')
      //       ->join('demand_data', 'demand.id', 'demand_data.master_id')
      //       ->select('demand.demand_no','demand.id')
      //       ->where('demand.company_location_id', $company_locations)
      //       ->where('demand_data.cancel_status', 1)
      //       ->where('demand_data.status', 1)
      //       ->where('demand.status', 1)
      //       ->where('demand.demand_status', 2)
      //       ->where('demand.quotation_skip', 0)
      //       //->where('demand_data.demand_complete_status',1)
      //       ->where('demand_data.quotation_id', 0)
      //       ->where('demand.quotation_approve', 0)
      //       ->groupBy('demand.demand_no')->get();
    }

    public static function getPrAndPrDataIds($quotation_id, $getids)
    {
        return DemandQuotation::where('quotation_id',$quotation_id)->groupBy($getids)->pluck($getids)->toArray();
    }
}
?>