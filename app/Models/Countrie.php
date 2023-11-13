<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Countrie extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function departamentos(): HasMany
    {
        return $this->hasMany(Departamento::class);
    }
}
