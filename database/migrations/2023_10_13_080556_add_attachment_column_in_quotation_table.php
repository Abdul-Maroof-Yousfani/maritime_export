<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttachmentColumnInQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //attachment
        Schema::connection('mysql2')->table('quotation', function (Blueprint $table) {
            $table->longText('attachment')->nullable();
            $table->longText('prepare_remark')->nullable();
            $table->string('prepare_username')->nullable();
            $table->longText('checked_remark')->nullable();
            $table->string('checked_username')->nullable();
            $table->longText('audited_remark')->nullable();
            $table->string('audited_username')->nullable();
            $table->longText('approved_remark')->nullable();
            $table->string('approved_username')->nullable();
        });
        Schema::connection('mdf')->table('quotation', function (Blueprint $table) {
            $table->longText('attachment')->nullable();
            $table->longText('prepare_remark')->nullable();
            $table->string('prepare_username')->nullable();
            $table->longText('checked_remark')->nullable();
            $table->string('checked_username')->nullable();
            $table->longText('audited_remark')->nullable();
            $table->string('audited_username')->nullable();
            $table->longText('approved_remark')->nullable();
            $table->string('approved_username')->nullable();
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
            $table->dropColumn('attachment');
            $table->dropColumn('prepare_remark');
            $table->dropColumn('prepare_username');
            $table->dropColumn('checked_remark');
            $table->dropColumn('checked_username');
            $table->dropColumn('audited_remark');
            $table->dropColumn('audited_username');
            $table->dropColumn('approved_remark');
            $table->dropColumn('approved_username');
        });
        Schema::connection('mdf')->table('quotation', function (Blueprint $table) {
            $table->dropColumn('attachment');
            $table->dropColumn('prepare_remark');
            $table->dropColumn('prepare_username');
            $table->dropColumn('checked_remark');
            $table->dropColumn('checked_username');
            $table->dropColumn('audited_remark');
            $table->dropColumn('audited_username');
            $table->dropColumn('approved_remark');
            $table->dropColumn('approved_username');
        });
    }
}
