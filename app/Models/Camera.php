<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $fillable = [
        'name', 
        'location', 
        'stream_url', 
        'latitude', 
        'longitude', 
        'is_active',
        'lanes',
        'line_config'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'line_config' => 'array',
    ];

    public function analytics()
    {
        return $this->hasMany(TrafficAnalytic::class);
    }

    public function latestAnalytic()
    {
        return $this->hasOne(TrafficAnalytic::class)->latestOfMany();
    }

    // Helper: Get line config for specific lane
    public function getLineConfig($laneNumber = 1)
    {
        $config = $this->line_config;
        if (!$config) return null;
        
        $lineKey = "line{$laneNumber}";
        return $config[$lineKey] ?? null;
    }
}
