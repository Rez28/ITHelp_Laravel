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
        Schema::table('request_helps', function (Blueprint $table) {
            $table->unsignedBigInteger('ip_mapping_id')->nullable()->after('ip_address');
            $table->foreign('ip_mapping_id')->references('id')->on('ip_mappings')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('request_helps', function (Blueprint $table) {
            $table->dropForeign(['ip_mapping_id']);
            $table->dropColumn('ip_mapping_id');
        });
    }
};
