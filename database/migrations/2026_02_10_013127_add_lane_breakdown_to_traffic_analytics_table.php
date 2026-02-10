<?php
// database/migrations/xxxx_xx_xx_add_lane_breakdown_to_traffic_analytics_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('traffic_analytics', function (Blueprint $table) {
            // Data per lane (untuk 2 lane)
            $table->json('lane1_data')->nullable()->after('truk_barang');
            $table->json('lane2_data')->nullable()->after('lane1_data');
        });
    }

    public function down()
    {
        Schema::table('traffic_analytics', function (Blueprint $table) {
            $table->dropColumn(['lane1_data', 'lane2_data']);
        });
    }
};