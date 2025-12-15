<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthOdp extends Model
{
    protected $table = 'ftth_odp';
    protected $primaryKey = 'id';

    protected $fillable = [
        'odc_id',
        'nama_odp',
        'odc_port',
        'lokasi',
        'latitude',
        'longitude',
        'jumlah_port',
        'port_tersedia',
        'splitter_ratio',
        'status',
        'jenis_odp',
        'area_coverage',
        'keterangan',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function odc()
    {
        return $this->belongsTo(FtthOdc::class, 'odc_id', 'id');
    }

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'odp_id', 'id');
    }
}
