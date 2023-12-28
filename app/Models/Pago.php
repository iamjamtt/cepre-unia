<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $fillable = [
        'codigo',
        'fecha',
        'verificacion',
        'activo',
        'borrado',
        'ciclo_id',
        'inscripcion_id',
        'lugarpago_id',
        'tipopago_id',
        'verification_id'
    ];

    public function ciclo(): BelongsTo
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function lugarpago(): BelongsTo
    {
        return $this->belongsTo(LugarPago::class);
    }

    public function tipopago(): BelongsTo
    {
        return $this->belongsTo(TipoPago::class);
    }
}
