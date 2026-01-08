<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSaleOrderExportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function($table) {
            $table->string('correspondent_bank')->after('status')->nullable();
            $table->string('account_title')->after('correspondent_bank')->nullable();
            $table->string('correspondent_account_usd')->after('account_title')->nullable();
            $table->string('correspondent_bank_swift')->after('correspondent_account_usd')->nullable();
            $table->string('details_of_payment')->after('correspondent_bank_swift')->nullable();
            $table->string('marking_labeling')->after('details_of_payment')->nullable();
            $table->string('consignee')->after('marking_labeling')->nullable();
            $table->string('notify_party')->after('consignee')->nullable();
            $table->string('document_to_provided')->after('notify_party')->nullable();
            $table->string('other_condition')->after('document_to_provided')->nullable();
            $table->string('force_majure')->after('document_to_provided')->nullable();
            $table->string('application_law')->after('other_condition')->nullable();
            $table->string('type_of_loading')->after('application_law')->nullable();
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
            $table->dropColumn(['correspondent_bank','account_title','correspondent_account_usd','correspondent_bank_swift','details_of_payment','marking_labeling','consignee','notify_party','document_to_provided','other_condition','application_law','force_majure','type_of_loading']);
        });
    }
}
