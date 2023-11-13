<?php

namespace App\Http\Middleware;

use App\Helpers\HelpersUnia;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministradorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()) {
            return redirect()->route('login');
        }

        $rol = HelpersUnia::getRol();

        if ($rol) {
            if ($rol->id != 1) {
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
