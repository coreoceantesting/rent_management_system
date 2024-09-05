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
            $table->enum('ar_approval', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('overall_status');
            $table->string('ar_approval_remark')->after('ar_approval')->nullable();
            $table->datetime('ar_approval_at')->after('ar_approval_remark')->nullable();
            $table->integer('ar_approval_by')->after('ar_approval_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_details', function (Blueprint $table) {
            $table->dropColumn('ar_approval');
            $table->dropColumn('ar_approval_remark');
            $table->dropColumn('ar_approval_at');
            $table->dropColumn('ar_approval_by');
        });
    }
};
