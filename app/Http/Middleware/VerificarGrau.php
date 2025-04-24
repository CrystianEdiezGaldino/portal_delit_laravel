<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarGrau
{
    public function handle(Request $request, Closure $next, $grauMinimo)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();
        
        if ($usuario->role === 'admin') {
            return $next($request);
        }

        if ($usuario->grau < $grauMinimo) {
            abort(403, 'Acesso negado. Você não tem permissão para acessar este recurso.');
        }

        return $next($request);
    }
} 