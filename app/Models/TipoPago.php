<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipoPago extends Model
{
    use HasFactory;

    protected $table = 'tipopagos';
    protected $fillable = [
        'costo',
        'extemporaneo',
        'grupo',
        'activo',
        'modalidad_id',
    ];

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class);
    }
}
