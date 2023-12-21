<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'borrado',
    ];

    public function carreras(): HasMany
    {
        return $this->hasMany(Carrera::class, 'area_id', 'id');
    }
}
