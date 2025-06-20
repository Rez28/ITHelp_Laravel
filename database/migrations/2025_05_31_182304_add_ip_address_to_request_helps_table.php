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
            $table->string('ip_address')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('request_helps', function (Blueprint $table) {
            $table->dropColumn('ip_address');
        });
    }
};
