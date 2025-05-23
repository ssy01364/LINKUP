<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;

class Disponibilidad extends Model
{
    use HasFactory;

    // Ajusta el nombre si tu tabla es singular; si fue plural, cámbialo a 'disponibilidades'
    protected $table = 'disponibilidad';

    protected $fillable = [
        'empresa_id',
        'inicio',
        'fin',
    ];

    // Para que 'inicio' y 'fin' sean instancias de Carbon automáticamente
    protected $casts = [
        'inicio' => 'datetime',
        'fin'    => 'datetime',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
