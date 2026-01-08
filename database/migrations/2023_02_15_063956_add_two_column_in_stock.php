<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnInStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('stock', function ($table) {
            $table->decimal('item_consumed_last_year',10,2)->nullable();
            $table->decimal('item_consumed_current_year',10,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('stock', function ($table) {
            $table->dropColumn('item_consumed_last_year',10,2);
            $table->dropColumn('item_consumed_current_year',10,2);
        });
    }
}
