<?php
// app/Models/Sector.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectores';

    /**
     * Campos asignables masivamente.
     */
    protected $fillable = [
        'nombre',
        'imagen',
    ];

    /**
     * Relación a Empresa.
     */
    public function empresas(): HasMany
    {
        return $this->hasMany(Empresa::class, 'sector_id');
    }

    /**
     * Accessor para obtener la URL completa de la imagen.
     */
    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen
            ? asset('images/' . $this->imagen)
            : null;
    }
}
