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
        Schema::table('tenants_details', function (Blueprint $table) {
            $table->date('demolished_date')->after('total_rent')->nullable();
            $table->string('bank_account_no')->after('demolished_date')->nullable();
            $table->string('bank_name')->after('bank_account_no')->nullable();
            $table->string('ifsc_code')->after('bank_name')->nullable();
            $table->string('branch_name')->after('ifsc_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants_details', function (Blueprint $table) {
            $table->dropColumn('demolished_date');
            $table->dropColumn('bank_account_no');
            $table->dropColumn('bank_name');
            $table->dropColumn('ifsc_code');
            $table->dropColumn('branch_name');
        });
    }
};
