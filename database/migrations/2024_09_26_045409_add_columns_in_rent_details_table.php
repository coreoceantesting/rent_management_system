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
            $table->enum('finance_dept_approval', [
                    'Pending', 
                    'Approved By Finance Clerk', 
                    'Rejected By Finance Clerk',
                    'Approved By Assistant Account Officer Two', 
                    'Rejected By Assistant Account Officer Two',
                    'Approved By Account Officer Two', 
                    'Rejected By Account Officer Two',
                    'Approved By Finance Controller', 
                    'Rejected By Finance Controller',
                    'Approved By Account Officer One', 
                    'Rejected By Account Officer One',
                    'Approved By Dy Accountant', 
                    'Rejected By Dy Accountant',
                    'Send to Account Officer One',
                    'Final Approved'    
                ])->default('Pending')->after('collector_approval_by');
            $table->string('finance_clerk_approval_remark')->after('finance_dept_approval')->nullable();
            $table->date('finance_clerk_approval_at')->after('finance_clerk_approval_remark')->nullable();
            $table->integer('finance_clerk_approval_by')->after('finance_clerk_approval_at')->nullable();
            $table->string('assistant_account_officer_two_approval_remark')->after('finance_clerk_approval_by')->nullable();
            $table->date('assistant_account_officer_two_approval_at')->after('assistant_account_officer_two_approval_remark')->nullable();
            $table->integer('assistant_account_officer_two_approval_by')->after('assistant_account_officer_two_approval_at')->nullable();
            $table->string('account_officer_two_approval_remark')->after('assistant_account_officer_two_approval_by')->nullable();
            $table->date('account_officer_two_approval_at')->after('account_officer_two_approval_remark')->nullable();
            $table->integer('account_officer_two_approval_by')->after('account_officer_two_approval_at')->nullable();
            $table->string('finance_controller_approval_remark')->after('account_officer_two_approval_by')->nullable();
            $table->date('finance_controller_approval_at')->after('finance_controller_approval_remark')->nullable();
            $table->integer('finance_controller_approval_by')->after('finance_controller_approval_at')->nullable();
            $table->string('account_officer_one_approval_remark')->after('finance_controller_approval_by')->nullable();
            $table->date('account_officer_one_approval_at')->after('account_officer_one_approval_remark')->nullable();
            $table->integer('account_officer_one_approval_by')->after('account_officer_one_approval_at')->nullable();
            $table->string('dy_accountant_approval_remark')->after('account_officer_one_approval_by')->nullable();
            $table->date('dy_accountant_approval_at')->after('dy_accountant_approval_remark')->nullable();
            $table->integer('dy_accountant_approval_by')->after('dy_accountant_approval_at')->nullable();
            $table->string('send_to_account_officer_one_approval_remark')->after('dy_accountant_approval_by')->nullable();
            $table->date('send_to_account_officer_one_approval_at')->after('send_to_account_officer_one_approval_remark')->nullable();
            $table->integer('send_to_account_officer_one_approval_by')->after('send_to_account_officer_one_approval_at')->nullable();
            $table->string('final_approval_remark')->after('send_to_account_officer_one_approval_by')->nullable();
            $table->date('final_approval_at')->after('final_approval_remark')->nullable();
            $table->integer('final_approval_by')->after('final_approval_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_details', function (Blueprint $table) {
            $table->dropColumn('finance_dept_approval');
            $table->dropColumn('finance_clerk_approval_remark');
            $table->dropColumn('finance_clerk_approval_at');
            $table->dropColumn('finance_clerk_approval_by');
            $table->dropColumn('assistant_account_officer_two_approval_remark');
            $table->dropColumn('assistant_account_officer_two_approval_at');
            $table->dropColumn('assistant_account_officer_two_approval_by');
            $table->dropColumn('account_officer_two_approval_remark');
            $table->dropColumn('account_officer_two_approval_at');
            $table->dropColumn('account_officer_two_approval_by');
            $table->dropColumn('finance_controller_approval_remark');
            $table->dropColumn('finance_controller_approval_at');
            $table->dropColumn('finance_controller_approval_by');
            $table->dropColumn('account_officer_one_approval_remark');
            $table->dropColumn('account_officer_one_approval_at');
            $table->dropColumn('account_officer_one_approval_by');
            $table->dropColumn('dy_accountant_approval_remark');
            $table->dropColumn('dy_accountant_approval_at');
            $table->dropColumn('dy_accountant_approval_by');
            $table->dropColumn('send_to_account_officer_one_approval_remark');
            $table->dropColumn('send_to_account_officer_one_approval_at');
            $table->dropColumn('send_to_account_officer_one_approval_by');
            $table->dropColumn('final_approval_remark');
            $table->dropColumn('final_approval_at');
            $table->dropColumn('final_approval_by');
        });
    }
};
