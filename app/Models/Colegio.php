<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colegio extends Model
{
    use HasFactory;

    protected $table = 'colegios';
    protected $fillable = [
        'id',
        'nombre',
        'gestion',
        'direccion',
        'codigoModular',
        'activo',
        'borrado',
        'distrito_id'
    ];

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class);
    }
}
