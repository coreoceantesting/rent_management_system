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
            $table->string('upload_annexure')->after('annexure_no')->nullable();
            $table->string('upload_rent_agreement')->after('demolished_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants_details', function (Blueprint $table) {
            $table->dropColumn('upload_annexure');
            $table->dropColumn('upload_rent_agreement');
        });
    }
};
