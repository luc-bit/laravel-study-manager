<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status === 'banned') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa bởi admin.']);
        }

        return $next($request);
    }
}
