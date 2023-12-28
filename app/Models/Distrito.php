<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distrito extends Model
{
    use HasFactory;

    protected $table = 'distritos';
    protected $fillable = [
        'nombre',
        'ubigeo',
        'activo',
        'provincia_id',
    ];

    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    public function colegios()
    {
        return $this->hasMany(Colegio::class);
    }
}
