<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAttachmentInQuotationTableApprove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //approved_attachment
        Schema::connection('mysql2')->table('quotation', function (Blueprint $table) {
            $table->longText('approved_attachment')->nullable();
        });
        Schema::connection('mdf')->table('quotation', function (Blueprint $table) {
            $table->longText('approved_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('quotation', function (Blueprint $table) {
            $table->dropColumn('approved_attachment');
        });
        Schema::connection('mdf')->table('quotation', function (Blueprint $table) {
            $table->dropColumn('approved_attachment');
        });
    }
}
