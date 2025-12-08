<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPengembalian extends Model
{
    protected $table = 'detail_pengembalians';
    protected $primaryKey = 'detail_pengembalian_id';
    public $timestamps = true;

    protected $fillable = [
        'pengembalian_id',
        'buku_id',
        'kondisi_buku_saat_kembali',
        'keterangan_kerusakan',
    ];

    public function pengembalian(): BelongsTo
    {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id', 'pengembalian_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'buku_id');
    }
}