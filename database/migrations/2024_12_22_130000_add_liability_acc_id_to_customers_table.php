<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLiabilityAccIdToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('customers', function (Blueprint $table) {
            // Add liability_acc_id column if it doesn't exist
            if (!Schema::connection('mysql2')->hasColumn('customers', 'liability_acc_id')) {
                $table->integer('liability_acc_id')->nullable()->after('acc_id');
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
        Schema::connection('mysql2')->table('customers', function (Blueprint $table) {
            // Drop liability_acc_id column if it exists
            if (Schema::connection('mysql2')->hasColumn('customers', 'liability_acc_id')) {
                $table->dropColumn('liability_acc_id');
            }
        });
    }
}

