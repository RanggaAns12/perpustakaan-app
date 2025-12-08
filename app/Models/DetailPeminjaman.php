<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamans';
    protected $primaryKey = 'detail_id';
    public $timestamps = true;

    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'kondisi_buku_saat_pinjam',
        'denda_per_buku',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'peminjaman_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'buku_id');
    }
}