<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IdUserNumeric
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id');

        // Si el id NO es numérico
        if (!is_numeric($id)) {
            // Se redirige al usuario a la ruta de error
            return redirect()->route('error');
        }
        return $next($request);
    }
}
