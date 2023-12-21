<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $fillable = [
        'nombre',
        'codigo',
        'activo',
        'countrie_id'
    ];

    public function countrie(): BelongsTo
    {
        return $this->belongsTo(Countrie::class);
    }

    public function provincias(): HasMany
    {
        return $this->hasMany(Provincia::class);
    }
}
