<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajarans';
    protected $primaryKey = 'tahun_id';
    public $timestamps = true;

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'is_aktif',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'tahun_id', 'tahun_id');
    }
}