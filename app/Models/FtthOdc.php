<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthOdc extends Model
{
    protected $table = 'ftth_odc';
    protected $primaryKey = 'id';

    protected $fillable = [
        'olt_id',
        'nama_odc',
        'olt_port',
        'lokasi',
        'latitude',
        'longitude',
        'jumlah_port',
        'port_tersedia',
        'splitter_ratio',
        'status',
        'jenis_kabel',
        'panjang_kabel',
        'area_coverage',
        'keterangan',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'panjang_kabel' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function olt()
    {
        return $this->belongsTo(FtthOlt::class, 'olt_id', 'id');
    }

    public function odp()
    {
        return $this->hasMany(FtthOdp::class, 'odc_id', 'id');
    }
}
