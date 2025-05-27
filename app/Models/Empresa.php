<?php
// app/Models/Empresa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Usuario;
use App\Models\Sector;
use App\Models\Servicio;
use App\Models\Disponibilidad;
use App\Models\Cita;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'usuario_id',
        'sector_id',
        'nombre',
        'descripcion',
        'direccion',
        'telefono',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(
            Servicio::class,
            'empresas_servicios',  // nombre real de la tabla pivote
            'empresa_id',          // FK en la tabla pivote que apunta a empresas
            'servicio_id'          // FK en la tabla pivote que apunta a servicios
        );
    }

    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'empresa_id');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'empresa_id');
    }
}
