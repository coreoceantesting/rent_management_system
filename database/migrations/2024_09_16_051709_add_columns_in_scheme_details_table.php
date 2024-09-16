<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scheme_details', function (Blueprint $table) {
            $table->string('demand_amount')->after('letter_upload_by')->nullable();
            $table->integer('demand_amount_inserted_by')->after('demand_amount')->nullable();
            $table->datetime('demand_amount_inserted_at')->after('demand_amount_inserted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scheme_details', function (Blueprint $table) {
            $table->dropColumn('demand_amount');
            $table->dropColumn('demand_amount_inserted_by');
            $table->dropColumn('demand_amount_inserted_at');
        });
    }
};
