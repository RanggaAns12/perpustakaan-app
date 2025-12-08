<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denda extends Model
{
    protected $table = 'dendas';
    protected $primaryKey = 'denda_id';
    public $timestamps = true;

    protected $fillable = [
        'pengembalian_id',
        'siswa_id',
        'jumlah_hari_terlambat',
        'tarif_denda_per_hari',
        'total_denda',
        'status_denda',
        'tanggal_bayar',
        'metode_pembayaran',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function pengembalian(): BelongsTo
    {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id', 'pengembalian_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }
}