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
        Schema::table('rent_details', function (Blueprint $table) {
            $table->string('rent_given_by_developer')->after('pay_amount')->nullable();
            $table->string('monthly_rent')->after('rent_given_by_developer')->nullable();
            $table->string('rent_paid')->after('monthly_rent')->nullable();
            $table->string('month')->after('rent_paid')->nullable();
            $table->string('percentage')->after('month')->nullable();
            $table->string('calculated_amount')->after('percentage')->nullable();
            $table->string('upload_doc')->after('calculated_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_details', function (Blueprint $table) {
            $table->dropColumn('rent_given_by_developer');
            $table->dropColumn('monthly_rent');
            $table->dropColumn('rent_paid');
            $table->dropColumn('month');
            $table->dropColumn('percentage');
            $table->dropColumn('calculated_amount');
            $table->dropColumn('upload_doc');
        });
    }
};
