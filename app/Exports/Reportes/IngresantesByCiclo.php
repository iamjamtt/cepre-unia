<?php

namespace App\Exports\Reportes;

use App\Models\Carrera;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class IngresantesByCiclo implements WithMultipleSheets
{
    use Exportable;

    protected $ciclo_id;

    public function __construct($ciclo_id)
    {
        $this->ciclo_id = $ciclo_id;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $carreras = Carrera::where('activo', 1)
            ->where('borrado', 0)
            ->get();

        foreach ($carreras as $carrera) {
            $sheets[] = new IngresantesByCicloByCarrera($this->ciclo_id, $carrera->id);
        }

        return $sheets;
    }
}
