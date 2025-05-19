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

    protected $fillable = [
        'nombre',
    ];

    public function empresas(): HasMany
    {
        return $this->hasMany(Empresa::class, 'sector_id');
    }
}
