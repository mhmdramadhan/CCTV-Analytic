<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficAnalytic extends Model
{
    protected $fillable = [
        'camera_id',
        'timestamp',
        'sepeda_motor',
        'mobil_penumpang',
        'kendaraan_sedang',
        'bus_besar',
        'truk_barang',
        'total',
        'lane1_data',    // ← BARU
        'lane2_data'     // ← BARU
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'sepeda_motor' => 'integer',
        'mobil_penumpang' => 'integer',
        'kendaraan_sedang' => 'integer',
        'bus_besar' => 'integer',
        'truk_barang' => 'integer',
        'total' => 'integer',
        'lane1_data' => 'array',  // ← JSON cast
        'lane2_data' => 'array'   // ← JSON cast
    ];

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }
}
