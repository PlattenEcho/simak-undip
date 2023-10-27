<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Periksa apakah mahasiswa telah memperbarui data diri
        if (auth()->check() && auth()->user()->profile_completed == 0) {
            return redirect()->route('mahasiswa.viewEditProfile')->with('error', 'Harap lengkapi data diri terlebih dahulu.');
        }

        return $next($request);
    }
}
