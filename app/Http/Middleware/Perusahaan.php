<?php

namespace App\Http\Middleware;

use App\Models\Perusahaan as AppPerusahaan;
use Closure;
use Illuminate\Http\Request;

class Perusahaan
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
        if (AppPerusahaan::count() > 0) {
            return $next($request);
        }
        return redirect()->route('perusahaan.create');
    }
}
