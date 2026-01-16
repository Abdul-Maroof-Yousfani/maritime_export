<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAdvancePaymentToIsAdvanceAndDropAdvanceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, convert existing data: "Yes" = 1, "No" or empty = 0, numeric 1 = 1, else = 0
        if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_payment')) {
            DB::connection('mysql2')->statement("
                UPDATE sale_order_exports 
                SET advance_payment = CASE 
                    WHEN advance_payment = 'Yes' OR advance_payment = '1' OR advance_payment = 1 THEN 1
                    ELSE 0
                END
            ");
        }
        
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Add is_advance column if it doesn't exist
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'is_advance')) {
                $table->tinyInteger('is_advance')->default(0)->after('insurance_coverd');
            }
        });
        
        // Copy data from advance_payment to is_advance if advance_payment exists
        if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_payment')) {
            DB::connection('mysql2')->statement("
                UPDATE sale_order_exports 
                SET is_advance = CASE 
                    WHEN advance_payment = 'Yes' OR advance_payment = '1' OR advance_payment = 1 THEN 1
                    ELSE 0
                END
            ");
        }
        
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Drop advance_payment column if it exists
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_payment')) {
                $table->dropColumn('advance_payment');
            }
            
            // Drop advance_type column if it exists
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_type')) {
                $table->dropColumn('advance_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Re-add advance_payment column
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_payment')) {
                $table->string('advance_payment')->nullable()->after('insurance_coverd');
            }
            
            // Re-add advance_type if needed
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_type')) {
                $table->string('advance_type')->nullable()->after('advance_payment');
            }
        });
        
        // Convert back: 1 = "Yes", 0 = "No"
        if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'is_advance')) {
            DB::connection('mysql2')->statement("
                UPDATE sale_order_exports 
                SET advance_payment = CASE 
                    WHEN is_advance = 1 THEN 'Yes'
                    ELSE 'No'
                END
            ");
        }
        
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Drop is_advance column
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'is_advance')) {
                $table->dropColumn('is_advance');
            }
        });
    }
}

