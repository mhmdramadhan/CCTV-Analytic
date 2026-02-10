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
        Schema::create('traffic_analytics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('camera_id')
                ->constrained('cameras')
                ->cascadeOnDelete();

            $table->timestamp('timestamp');

            $table->integer('sepeda_motor')->default(0);
            $table->integer('mobil_penumpang')->default(0);
            $table->integer('kendaraan_sedang')->default(0);
            $table->integer('bus_besar')->default(0);
            $table->integer('truk_barang')->default(0);

            $table->integer('total')->default(0);

            $table->timestamps();

            // INDEX idx_camera_timestamp (camera_id, timestamp)
            $table->index(['camera_id', 'timestamp'], 'idx_camera_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_analytics');
    }
};
