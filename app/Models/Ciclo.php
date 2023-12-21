<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclos';
    protected $fillable = [
        'numero',
        'nombre',
        'descripcion',
        'resolucion_ruta',
        'fechaInicio',
        'fechaFin',
        'estado', // 'activo', 'inactivo
        'activo',
        'borrado',
    ];

    public $timestamps = false;

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'LIKE', "%$search%")
            ->orWhere('descripcion', 'LIKE', "%$search%");
    }
}
