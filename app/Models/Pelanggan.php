<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'data_pelanggan';
    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'nama_pelanggan',
        'alamat_pelanggan',
        'telepon_pelanggan',
        'email_pelanggan',
        'id_paket',
        'odp_id',
        'pop_id',
        'status_aktif',
        'tgl_daftar',
        'tgl_expired',
        'last_paid_date',
        'mikrotik_username',
        'mikrotik_password',
        'mikrotik_profile',
        'mikrotik_service',
        'static_ip',
        'odp_port_id',
        'onu_id',
        'signal_rx',
        'signal_tx',
        'ftth_status',
        'installation_date',
        'technician',
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
        'tgl_expired' => 'date',
        'last_paid_date' => 'date',
        'installation_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id_paket');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_pelanggan', 'id_pelanggan');
    }
}
