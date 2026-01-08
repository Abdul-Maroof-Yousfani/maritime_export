<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UploadCustomerDetail implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
       
            foreach ($collection as $key => $customer) {
                // echo "<pre>";
                // print_r($customer['account_code']);
                // echo "</pre>";
                if (isset($customer['customer_names']) && isset($customer['account_code'])) {
                    $account = Account::where('code', $customer['account_code'])->where('status', 1)->first();
                    // dd($customer['customer_names'], $account);
                    Customer::create([
                        'acc_id' => $account->id,
                        'customer_type' => 3,
                        'purchaser_type' => 2,
                        'name' => $customer['customer_names'],
                        'action' => "Create",
                        'username' => "Amir",
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                    ]);
                }
            }
          
        // dd();
    }
}
