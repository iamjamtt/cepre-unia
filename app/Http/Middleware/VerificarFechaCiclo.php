<?php

namespace App\Http\Middleware;

use App\Helpers\HelpersUnia;
use App\Models\Ciclo;
use App\Models\Fecha;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarFechaCiclo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ciclo = Ciclo::find(HelpersUnia::getIdCiclo());
        $fechas = Fecha::where('ciclo_id', $ciclo->id)->first();
        $fechaInicio = $fechas->iniInscripcion;
        $fechaFin = $fechas->finInscripcion;
        if (Carbon::now()->between($fechaInicio, $fechaFin)) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
