<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $fillable = [
        'id',
        'nombres',
        'apePaterno',
        'apeMaterno',
        'dni',
        'celular',
        'celularApoderado',
        'direccion',
        'fechaNac',
        'sexo',
        'dominio_lengua',
        'segunda_lengua',
        'comunidad',
        'colegioFin',
        'observacion',
        'activo',
        'borrado',
        'completo',
        'colegio_id',
        'distrito_id',
        'grupo_id',
        'language_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class);
    }

    public function colegio(): BelongsTo
    {
        return $this->belongsTo(Colegio::class);
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }

    public function archivos(): HasMany
    {
        return $this->hasMany(Archivo::class);
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function preguntas(): BelongsToMany
    {
        return $this->belongsToMany(Pregunta::class, 'persona_pregunta', 'persona_id', 'pregunta_id')
            ->withPivot('valor');
    }
}
