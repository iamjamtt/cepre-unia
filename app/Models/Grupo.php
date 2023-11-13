<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';
    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function personas(): HasOne
    {
        return $this->hasOne(Persona::class);
    }
}
