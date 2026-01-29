<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPackingListNoToPackingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('packing_lists', function (Blueprint $table) {
            if (!Schema::connection('mysql2')->hasColumn('packing_lists', 'packing_list_no')) {
                $table->string('packing_list_no')->nullable()->after('commercial_invoice_id');
            }
        });

        // Backfill packing_list_no for existing rows (if any)
        $currentYearLastTwoDigits = date('y');
        $previousYearLastTwoDigits = date('y', strtotime('-1 year'));
        $yearCode = $previousYearLastTwoDigits . $currentYearLastTwoDigits; // e.g., 2526
        $prefix = 'PL' . $yearCode . '-'; // e.g., PL2526-

        $last = DB::connection('mysql2')->selectOne("
            SELECT packing_list_no
            FROM packing_lists
            WHERE packing_list_no LIKE '" . $prefix . "%'
            ORDER BY CAST(SUBSTRING(packing_list_no, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC, packing_list_no DESC
            LIMIT 1
        ");

        $nextNumber = 1;
        if ($last && !empty($last->packing_list_no)) {
            $parts = explode('-', $last->packing_list_no);
            if (count($parts) === 2 && is_numeric($parts[1])) {
                $nextNumber = ((int) $parts[1]) + 1;
            }
        }

        $rows = DB::connection('mysql2')
            ->table('packing_lists')
            ->whereNull('packing_list_no')
            ->orderBy('id', 'asc')
            ->get(['id']);

        foreach ($rows as $row) {
            $sequential = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            DB::connection('mysql2')
                ->table('packing_lists')
                ->where('id', $row->id)
                ->update(['packing_list_no' => $prefix . $sequential]);
            $nextNumber++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('packing_lists', function (Blueprint $table) {
            if (Schema::connection('mysql2')->hasColumn('packing_lists', 'packing_list_no')) {
                $table->dropColumn('packing_list_no');
            }
        });
    }
}
