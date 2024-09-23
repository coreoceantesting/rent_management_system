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
            $table->string('final_amount')->after('letter_upload_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scheme_details', function (Blueprint $table) {
            $table->dropColumn('final_amount');
        });
    }
};
