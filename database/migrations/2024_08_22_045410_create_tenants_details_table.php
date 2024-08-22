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
        Schema::create('tenants_details', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_tenant')->nullable();
            $table->integer('annexure_no')->nullable();
            $table->string('scheme_name')->nullable();
            $table->string('eligible_or_not')->nullable();
            $table->string('residential_or_commercial')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('aadhaar_no')->nullable();
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
        Schema::dropIfExists('tenants_details');
    }
};
