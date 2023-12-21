<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archivo extends Model
{
    use HasFactory;

    protected $table = 'archivos';
    protected $fillable = [
        'nombre',
        'ruta',
        'tipo',
        'estado', // 'activo', 'inactivo
        'size',
        'activo',
        'borrado',
        'ciclo_id',
        'persona_id',
    ];

    public function ciclo(): BelongsTo
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }
}
