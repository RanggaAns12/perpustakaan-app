<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BukuPenulis extends Model
{
    use HasFactory;

    protected $table = 'buku_penulis';
    protected $primaryKey = 'buku_penulis_id';
    public $timestamps = true;

    protected $fillable = [
        'buku_id',
        'penulis_id',
    ];

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'buku_id');
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(Penulis::class, 'penulis_id', 'penulis_id');
    }
}