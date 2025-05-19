<?php
// app/Models/Usuario.php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'role_id',
    ];

    // Oculta el hash al serializar
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Necesario para que Sanctum use el campo password_hash
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Si es empresa, relación a su registro en empresas
    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 'usuario_id');
    }

    // Si es cliente, sus citas
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'cliente_id');
    }
}
