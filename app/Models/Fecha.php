<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fecha extends Model
{
    use HasFactory;

    protected $table = 'fechas';
    protected $fillable = [
        'iniInscripcion',
        'iniExtemporaneo',
        'finInscripcion',
        'reconocerLocal',
        'diaExamen',
        'activo',
        'ciclo_id'
    ];

    public $timestamps = false;

    public function ciclo(): BelongsTo
    {
        return $this->belongsTo(Ciclo::class);
    }
}
