<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringPppoe extends Model
{
    protected $table = 'monitoring_pppoe';
    protected $primaryKey = 'id_monitoring';

    protected $fillable = [
        'id_pelanggan',
        'mikrotik_username',
        'session_id',
        'ip_address',
        'mac_address',
        'interface',
        'caller_id',
        'uptime',
        'bytes_in',
        'bytes_out',
        'packets_in',
        'packets_out',
        'session_start',
        'session_end',
        'disconnect_reason',
        'status',
    ];

    protected $casts = [
        'bytes_in' => 'integer',
        'bytes_out' => 'integer',
        'packets_in' => 'integer',
        'packets_out' => 'integer',
        'session_start' => 'datetime',
        'session_end' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
