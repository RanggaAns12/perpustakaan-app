<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    protected $table = 'gurus';
    protected $primaryKey = 'guru_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jenis_kelamin',
        'mata_pelajaran',
        'nomor_telepon',
        'email',
        'foto_profil',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'wali_kelas', 'guru_id');
    }
}