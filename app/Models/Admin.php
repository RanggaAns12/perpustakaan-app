<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'nomor_telepon',
        'foto_profil',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}