<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penerbit extends Model
{
    protected $table = 'penerbits';
    protected $primaryKey = 'penerbit_id';
    public $timestamps = true;

    protected $fillable = [
        'nama_penerbit',
        'alamat_penerbit',
        'kota',
        'telepon_penerbit',
        'email_penerbit',
    ];

    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class, 'penerbit_id', 'penerbit_id');
    }
}