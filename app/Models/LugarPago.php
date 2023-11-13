<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarPago extends Model
{
    use HasFactory;

    protected $table = 'lugarpagos';
    protected $fillable = [
        'nombre',
        'imagen',
        'activo',
    ];
}
