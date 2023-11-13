<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'preguntas';
    protected $fillable = [
        'nombre',
        'item',
        'tipo',
        'activo',
    ];

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class);
    }
}
