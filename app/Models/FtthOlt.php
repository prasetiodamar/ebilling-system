<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthOlt extends Model
{
    protected $table = 'ftth_olt';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pop_id',
        'nama_olt',
        'ip_address',
        'lokasi',
        'latitude',
        'longitude',
        'merk',
        'model',
        'jumlah_port_pon',
        'port_tersedia',
        'status',
        'snmp_community',
        'snmp_version',
        'keterangan',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function pop()
    {
        return $this->belongsTo(FtthPop::class, 'pop_id', 'id');
    }
}
