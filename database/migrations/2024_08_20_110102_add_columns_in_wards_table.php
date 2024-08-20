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
        Schema::table('wards', function (Blueprint $table) {
            $table->integer('region')->after('name')->nullable();
            $table->string('created_by_ip', 100)->after('initial')->nullable();
            $table->string('updated_by_ip', 100)->after('created_by_ip')->nullable();
            $table->string('deleted_by_ip', 100)->after('updated_by_ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wards', function (Blueprint $table) {
            $table->dropColumn('region');
            $table->dropColumn('created_by_ip');
            $table->dropColumn('updated_by_ip');
            $table->dropColumn('deleted_by_ip');
        });
    }
};
