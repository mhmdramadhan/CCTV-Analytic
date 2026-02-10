<?php
// database/migrations/xxxx_xx_xx_add_lane_config_to_cameras_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cameras', function (Blueprint $table) {
            $table->integer('lanes')->default(1)->after('is_active');
            $table->json('line_config')->nullable()->after('lanes');
        });
    }

    public function down()
    {
        Schema::table('cameras', function (Blueprint $table) {
            $table->dropColumn(['lanes', 'line_config']);
        });
    }
};