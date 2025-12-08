<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $primaryKey = 'buku_id';
    public $timestamps = true;

    protected $fillable = [
        'kategori_id',
        'penerbit_id',
        'isbn',
        'judul_buku',
        'tahun_terbit',
        'jumlah_halaman',
        'bahasa',
        'sinopsis',
        'cover_buku',
        'jumlah_eksemplar_total',
        'jumlah_eksemplar_tersedia',
        'lokasi_rak',
        'status_buku',
        'created_by',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function penerbit(): BelongsTo
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id', 'penerbit_id');
    }

    public function penulis(): BelongsToMany
    {
        return $this->belongsToMany(Penulis::class, 'buku_penulis', 'buku_id', 'penulis_id')
                    ->withTimestamps();
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'buku_id', 'buku_id');
    }

    public function detailPengembalian(): HasMany
    {
        return $this->hasMany(DetailPengembalian::class, 'buku_id', 'buku_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}