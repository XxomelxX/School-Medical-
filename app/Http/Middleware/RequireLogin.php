<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class RequireLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('user_id')) {
            return redirect()->route('login');
        }

        if (! $request->session()->has('user_role')) {
            $user = User::find($request->session('user_id'));

            if ($user) {
                $request->session()->put([
                    'user_role' => $user->role,
                    'student_id' => $user->student_id,
                    'user_name' => $user->name,
                ]);
            }
        }

        return $next($request);
    }
}
