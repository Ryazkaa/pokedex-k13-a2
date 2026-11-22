<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureDeveloper
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isDeveloper()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak: Operasi ini membutuhkan hak akses Developer Kelompok 13.'
                ], 403);
            }

            return redirect()->route('pokedex.index')->with('error', 'Akses ditolak: Hanya Developer Kelompok 13 yang dapat mengimpor dataset master.');
        }

        return $next($request);
    }
}
