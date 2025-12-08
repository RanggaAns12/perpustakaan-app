<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswas';
    protected $primaryKey = 'siswa_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nisn',
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'nomor_telepon',
        'foto_profil',
        'nama_orangtua',
        'telepon_orangtua',
        'tanggal_daftar',
        'status_siswa',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'siswa_id', 'siswa_id');
    }

    public function pengembalians(): HasMany
    {
        return $this->hasMany(Pengembalian::class, 'siswa_id', 'siswa_id');
    }

    public function dendas(): HasMany
    {
        return $this->hasMany(Denda::class, 'siswa_id', 'siswa_id');
    }
}