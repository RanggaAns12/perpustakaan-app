<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $primaryKey = 'peminjaman_id';
    public $timestamps = true;

    protected $fillable = [
        'kode_transaksi',
        'siswa_id',
        'pustakawan_id',
        'tanggal_peminjaman',
        'tanggal_jatuh_tempo',
        'status_peminjaman',
        'catatan',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function pustakawan(): BelongsTo
    {
        return $this->belongsTo(Pustakawan::class, 'pustakawan_id', 'pustakawan_id');
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id', 'peminjaman_id');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id', 'peminjaman_id');
    }
}