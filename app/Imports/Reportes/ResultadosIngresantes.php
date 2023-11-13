<?php

namespace App\Imports\Reportes;

use App\Helpers\HelpersUnia;
use App\Models\Ingresante;
use App\Models\Inscripcion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ResultadosIngresantes implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $item) {
            $inscripcion = Inscripcion::join('personas', 'personas.id','=','inscripcions.persona_id')
                ->where('inscripcions.activo', 1)
                ->where('inscripcions.borrado', 0)
                ->where('personas.dni', $item[0])
                ->where('inscripcions.ciclo_id', HelpersUnia::getIdCiclo())
                ->select('inscripcions.*')
                ->first();
            if ($item[2] === 1) {
                $ingresante = new Ingresante();
                $ingresante->estado = 1;
                $ingresante->ciclo_id = $inscripcion->ciclo_id;
                $ingresante->carrera_id = $inscripcion->carrera_id;
                $ingresante->inscripcion_id = $inscripcion->id;
                $ingresante->save();

                $inscripcion->ingreso = 1;
            }
            $inscripcion->puntaje = $item[1];
            $inscripcion->save();
        }
    }
}
