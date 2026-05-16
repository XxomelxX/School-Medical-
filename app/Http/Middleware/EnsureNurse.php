<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureNurse
{
    public function handle(Request $request, Closure $next)
    {
        if (session('user_role') !== 'nurse') {
            return redirect('/')->withErrors(['access' => 'This area is only available to clinic nurses.']);
        }

        return $next($request);
    }
}
