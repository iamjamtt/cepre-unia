<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacante extends Model
{
    use HasFactory;

    protected $table = 'vacantes';
    protected $fillable = [
        'vacantes',
        'carrera_id',
        'ciclo_id',
        'modalidad_id'
    ];

    public $timestamps = false;

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    public function ciclo(): BelongsTo
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class);
    }
}
