<?php
// app/Models/Servicio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
            'empresas_servicios',
            'servicio_id',
            'empresa_id'
        );
    }

    public function citas(): BelongsToMany
    {
        // Aunque la cita guarda servicio_id, a veces conviene acceder
        return $this->hasMany(Cita::class, 'servicio_id');
    }
}
