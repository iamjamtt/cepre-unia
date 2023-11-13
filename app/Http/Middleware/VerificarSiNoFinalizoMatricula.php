<?php

namespace App\Http\Middleware;

use App\Helpers\HelpersUnia;
use App\Models\Inscripcion;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSiNoFinalizoMatricula
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $persona = $user->persona;

        $inscripcion = Inscripcion::where('persona_id', $persona->id)
            ->where('user_id', $user->id)
            ->where('ciclo_id', HelpersUnia::getIdCiclo())
            ->where('activo', 1)
            ->where('borrado', 0)
            ->orderBy('id', 'desc')
            ->first();

        if (!$inscripcion) {
            return redirect()->route('postulante.matricula');
        }

        return $next($request);
    }
}
