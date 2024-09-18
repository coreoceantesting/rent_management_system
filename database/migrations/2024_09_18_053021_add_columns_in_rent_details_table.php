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
            $table->enum('hod_approval', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('ar_approval');
            $table->string('hod_approval_remark')->after('hod_approval')->nullable();
            $table->datetime('hod_approval_at')->after('hod_approval_remark')->nullable();
            $table->integer('hod_approval_by')->after('hod_approval_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_details', function (Blueprint $table) {
            $table->dropColumn('hod_approval');
            $table->dropColumn('hod_approval_remark');
            $table->dropColumn('hod_approval_at');
            $table->dropColumn('hod_approval_by');
        });
    }
};
