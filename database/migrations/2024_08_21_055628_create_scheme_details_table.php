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
        Schema::create('scheme_details', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_id')->nullable();
            $table->integer('region_name')->nullable();
            $table->integer('ward_name')->nullable();
            $table->string('village_name')->nullable();
            $table->string('scheme_name')->nullable();
            $table->string('scheme_address')->nullable();
            $table->string('scheme_cst_number')->nullable();
            $table->string('scheme_proposal_number')->nullable();
            $table->string('developer_name')->nullable();
            $table->string('developer_email')->nullable();
            $table->string('developer_contact_number')->nullable();
            $table->string('architect_name')->nullable();
            $table->string('architect_email')->nullable();
            $table->string('architect_contact_number')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->string('created_by_ip')->nullable();
            $table->string('updated_by_ip')->nullable();
            $table->string('deleted_by_ip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheme_details');
    }
};
