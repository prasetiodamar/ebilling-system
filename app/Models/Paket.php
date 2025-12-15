<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket_internet';
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'nama_paket',
        'profile_name',
        'harga',
        'deskripsi',
        'local_address',
        'remote_address',
        'rate_limit_rx',
        'rate_limit_tx',
        'burst_limit_rx',
        'burst_limit_tx',
        'priority',
        'dns_server',
        'status_paket',
        'sync_mikrotik',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_sync' => 'datetime',
    ];

    // Relationships
    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'id_paket', 'id_paket');
    }
}
