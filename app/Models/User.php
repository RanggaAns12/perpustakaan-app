<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'username',
        'password',
        'email',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isPustakawan(): bool
    {
        return $this->role_id === 2;
    }

    public function isSiswa(): bool
    {
        return $this->role_id === 3;
    }

    public function isGuru(): bool
    {
        return $this->role_id === 4;
    }

    public function getRoleName(): string
    {
        return $this->role->role_name ?? 'Unknown';
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'user_id');
    }

    public function pustakawan(): HasOne
    {
        return $this->hasOne(Pustakawan::class, 'user_id', 'user_id');
    }

    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class, 'user_id', 'user_id');
    }

    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class, 'user_id', 'user_id');
    }

    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class, 'user_id', 'user_id');
    }
}