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
            $table->string('scheme_confirmation_letter')->after('architect_contact_number')->nullable();
            $table->string('confirmation_letter_remark')->after('scheme_confirmation_letter')->nullable();
            $table->string('letter_upload_by')->after('confirmation_letter_remark')->nullable();
            $table->datetime('letter_upload_at')->after('letter_upload_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scheme_details', function (Blueprint $table) {
            $table->dropColumn('scheme_confirmation_letter');
            $table->dropColumn('confirmation_letter_remark');
            $table->dropColumn('letter_upload_by');
            $table->dropColumn('letter_upload_at');
        });
    }
};
