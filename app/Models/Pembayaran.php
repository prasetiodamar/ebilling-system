<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    const UPDATED_AT = null; // Table hanya punya created_at

    protected $fillable = [
        'id_tagihan',
        'id_pelanggan',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_bayar',
        'keterangan',
        'id_user_pencatat',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah_bayar' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'id_user_pencatat', 'id_user');
    }
}
