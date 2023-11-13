<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripcions';
    protected $fillable = [
        'estado', // 'activo', 'inactivo
        'aula',
        'numero',
        'fecha',
        'foto',
        'documento',
        'ingreso',
        'puntaje',
        'omg',
        'ome',
        'opcion',
        'activo',
        'borrado',
        'carrera_id',
        'carrera2_id',
        'ciclo_id',
        'modalidad_id',
        'persona_id',
        'turno_id',
        'user_id',
    ];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    public function carrera2(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class);
    }

    public function pago(): HasOne
    {
        return $this->hasOne(Pago::class);
    }

    public function ciclo(): BelongsTo
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    public function ingresante(): HasOne
    {
        return $this->hasOne(ingresante::class);
    }
}
