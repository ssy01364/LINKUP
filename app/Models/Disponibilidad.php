<?php
// app/Models/Disponibilidad.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disponibilidad extends Model
{
    use HasFactory;

    protected $table = 'disponibilidad';

    protected $fillable = [
        'empresa_id',
        'inicio',
        'fin',
        'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'inicio'     => 'datetime',
        'fin'        => 'datetime',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
