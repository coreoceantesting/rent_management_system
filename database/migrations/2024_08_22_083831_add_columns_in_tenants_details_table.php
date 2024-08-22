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
            $table->date('rent_from')->after('aadhaar_no')->nullable();
            $table->date('rent_to')->after('rent_from')->nullable();
            $table->string('total_rent')->after('rent_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants_details', function (Blueprint $table) {
            $table->dropColumn('rent_from');
            $table->dropColumn('rent_to');
            $table->dropColumn('total_rent');
        });
    }
};
