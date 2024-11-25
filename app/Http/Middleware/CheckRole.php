<?php

namespace App\Http\Middleware;

use Closure;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            Alert::warning('403', 'Forbidden Access');
            return redirect('/');
        }

        return $next($request);
    }
}
