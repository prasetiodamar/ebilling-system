<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthPop extends Model
{
    protected $table = 'ftth_pop';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_pop',
        'lokasi',
        'latitude',
        'longitude',
        'alamat_lengkap',
        'kapasitas_olt',
        'jumlah_olt',
        'status',
        'pic_nama',
        'pic_telepon',
        'keterangan',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function olt()
    {
        return $this->hasMany(FtthOlt::class, 'pop_id', 'id');
    }
}
