<?php

namespace App\Imports\Imports;

use App\Helpers\FinanceHelper;
use App\Models\Account;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UploadChartOfAccount implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            // dd($value);
            if ($value['account_name']) {
                $value['account_name'] = trim($value['account_name']);
                $level1 = Account::where('name', 'like', $value['account_name'])->where('status', 1)->first();
                if($level1){
                    $level1 = $level1->code;
                }else{
                    $levelOne = Account::where('name', 'like', trim($value['account_type_level_4']))->where('status', 1)->first();
                    $code = Account::where([['level1', $levelOne->level1], ['level2', $levelOne->level2], ['level3', $levelOne->level3], ['level4', $levelOne->level4]])->max('level5') + 1;
                    // dd($code);
                    Account::create([
                        'code' => $levelOne->level1.'-'.$levelOne->level2.'-'.$levelOne->level3.'-'.$levelOne->level4.'-'.$code,
                        'parent_code' => $levelOne->level1.'-'.$levelOne->level2.'-'.$levelOne->level3.'-'.$levelOne->level4,
                        'level1' => $levelOne->level1,
                        'level2' => $levelOne->level2,
                        'level3' => $levelOne->level3,
                        'level4' => $levelOne->level4,
                        'level5' => $code,
                        'operational' => 1,
                        'name' => $value['account_name'],
                        'username' => Auth::user()->name,
                        'action' => 'create',
                        'status' => 1,
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                    ]);
                }
            }
        }
        // dd($level1);
        // dd($value);
    }

   
}
