<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'kategori_id';
    public $timestamps = true;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'kode_warna',
    ];

    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class, 'kategori_id', 'kategori_id');
    }
}