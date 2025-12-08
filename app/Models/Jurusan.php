<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'jurusans';
    protected $primaryKey = 'jurusan_id';
    public $timestamps = true;

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi',
    ];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'jurusan_id', 'jurusan_id');
    }
}