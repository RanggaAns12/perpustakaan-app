<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';
    protected $primaryKey = 'pengaturan_id';
    public $timestamps = true;

    protected $fillable = [
        'max_peminjaman_hari',
        'max_buku_dipinjam',
        'denda_per_hari',
        'masa_tenggang',
        'updated_by',
    ];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }
}