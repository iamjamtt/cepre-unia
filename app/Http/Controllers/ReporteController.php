<?php

namespace App\Http\Controllers;

use App\Helpers\HelpersUnia;
use App\Models\Inscripcion;
use App\Models\Persona;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function ficha_matricula($inscripcion_id) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        if (!$inscripcion) {
            abort(404);
        }
        $rol = HelpersUnia::getRol();
        if ($rol->id == 4) {
            if ($inscripcion->estado == 1) {
                abort(404);
            }
        }
        $persona = $inscripcion->persona;
        $user = $persona->user;
        $colegio = $persona->colegio;
        $pdf = Pdf::loadView('components.reportes.ficha-matricula', [
            'inscripcion' => $inscripcion,
            'persona' => $persona,
            'user' => $user,
            'colegio' => $colegio
        ]);
        return $pdf->stream('ficha-matricula.pdf');
    }

    public function carta_compromiso($inscripcion_id) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        if (!$inscripcion) {
            abort(404);
        }
        $persona = $inscripcion->persona;
        $pdf = Pdf::loadView('components.reportes.carta-compromiso', [
            'inscripcion' => $inscripcion,
            'persona' => $persona
        ]);
        return $pdf->stream('carta-compromiso.pdf');
    }

    public function declaracion_jurada($inscripcion_id) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        if (!$inscripcion) {
            abort(404);
        }
        $persona = $inscripcion->persona;
        $pdf = Pdf::loadView('components.reportes.declaracion-jurada', [
            'inscripcion' => $inscripcion,
            'persona' => $persona
        ]);
        return $pdf->stream('declaracion-jurada.pdf');
    }
}
