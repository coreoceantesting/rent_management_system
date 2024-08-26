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
            $table->enum('overall_status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('branch_name');
            $table->enum('finance_approval', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('overall_status');
            $table->string('finance_approval_remark')->after('finance_approval')->nullable();
            $table->datetime('finance_approval_at')->after('finance_approval_remark')->nullable();
            $table->integer('finance_approval_by')->after('finance_approval_at')->nullable();
            $table->enum('collector_approval', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('finance_approval_by');
            $table->string('collector_approval_remark')->after('collector_approval')->nullable();
            $table->datetime('collector_approval_at')->after('collector_approval_remark')->nullable();
            $table->integer('collector_approval_by')->after('collector_approval_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants_details', function (Blueprint $table) {
            $table->dropColumn('overall_status');
            $table->dropColumn('finance_approval');
            $table->dropColumn('finance_approval_remark');
            $table->dropColumn('finance_approval_at');
            $table->dropColumn('finance_approval_by');
            $table->dropColumn('collector_approval');
            $table->dropColumn('collector_approval_remark');
            $table->dropColumn('collector_approval_at');
            $table->dropColumn('collector_approval_by');
        });
    }
};
