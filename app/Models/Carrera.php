<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carreras';
    protected $fillable = [
        'nombre',
        'abreviatura',
        'siga',
        'malla_curricular',
        'activo',
        'borrado',
        'area_id',
        'facultad_id',
    ];

    public $timestamps = false;

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function facultad(): BelongsTo
    {
        return $this->belongsTo(Facultad::class);
    }
}
