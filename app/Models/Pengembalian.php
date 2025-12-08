<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengembalian extends Model
{
    protected $table = 'pengembalians';
    protected $primaryKey = 'pengembalian_id';
    public $timestamps = true;

    protected $fillable = [
        'kode_transaksi',
        'peminjaman_id',
        'siswa_id',
        'pustakawan_id',
        'tanggal_pengembalian',
        'status_pengembalian',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'peminjaman_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function pustakawan(): BelongsTo
    {
        return $this->belongsTo(Pustakawan::class, 'pustakawan_id', 'pustakawan_id');
    }

    public function detailPengembalian(): HasMany
    {
        return $this->hasMany(DetailPengembalian::class, 'pengembalian_id', 'pengembalian_id');
    }

    public function denda(): HasOne
    {
        return $this->hasOne(Denda::class, 'pengembalian_id', 'pengembalian_id');
    }
}