<?php
// app/Models/Servicio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function empresas(): BelongsToMany
    {
        return $this->belongsToMany(
            Empresa::class,
            'empresas_servicios',  // tabla pivote
            'servicio_id',         // FK pivote → this servicio
            'empresa_id'           // FK pivote → empresas
        );
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'servicio_id');
    }
}
