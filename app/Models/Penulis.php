<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Penulis extends Model
{
    protected $table = 'penulis';
    protected $primaryKey = 'penulis_id';
    public $timestamps = true;

    protected $fillable = [
        'nama_penulis',
        'biografi',
        'kebangsaan',
    ];

    public function bukus(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'buku_penulis', 'penulis_id', 'buku_id')
                    ->withTimestamps();
    }
}