<?php

namespace App\Http\Middleware;

use App\Helpers\HelpersUnia;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrabajadorMiddleware
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
            if ($rol->id != 2) {
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
