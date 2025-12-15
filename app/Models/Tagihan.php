<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tagihan',
        'id_pelanggan',
        'bulan_tagihan',
        'tahun_tagihan',
        'jumlah_tagihan',
        'tgl_jatuh_tempo',
        'status_tagihan',
        'deskripsi',
        'auto_generated',
        'generated_by',
    ];

    protected $casts = [
        'jumlah_tagihan' => 'decimal:2',
        'tgl_jatuh_tempo' => 'date',
        'bulan_tagihan' => 'integer',
        'tahun_tagihan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_tagihan', 'id_tagihan');
    }
}
