<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pustakawan extends Model
{
    protected $table = 'pustakawans';
    protected $primaryKey = 'pustakawan_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'nomor_telepon',
        'foto_profil',
        'shift_kerja',
        'tanggal_bergabung',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'pustakawan_id', 'pustakawan_id');
    }

    public function pengembalians(): HasMany
    {
        return $this->hasMany(Pengembalian::class, 'pustakawan_id', 'pustakawan_id');
    }
}