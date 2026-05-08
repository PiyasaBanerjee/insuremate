<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->role !== 'agent' || !$user->agent || $user->agent->status !== 'approved') {
            return redirect()->route('home')
                ->with('error', 'Access denied. You must be an approved agent to access this area.');
        }

        return $next($request);
    }
}
