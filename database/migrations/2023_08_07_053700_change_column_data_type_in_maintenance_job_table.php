<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnDataTypeInMaintenanceJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('maintenance_jobs', function (Blueprint $table) {
            $table->string('labour_qty')->change();
            $table->renameColumn('labour_qty', 'labour_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('maintenance_jobs', function (Blueprint $table) {
            $table->renameColumn('labour_description', 'labour_qty');
            $table->decimal('labour_qty')->change();
        });
    }
}
