<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingresante extends Model
{
    use HasFactory;

    protected $table = 'ingresantes';
    protected $fillable = [
        'estado',
        'expediente',
        'documento',
        'observacion',
        'ciclo_id',
        'carrera_id',
        'inscripcion_id'
    ];

    public $timestamps = false;

    public function ciclo(): BelongsTo
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class);
    }
}
