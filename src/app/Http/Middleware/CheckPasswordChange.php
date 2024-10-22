<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Nếu người dùng chưa đổi mật khẩu, chuyển hướng đến trang thay đổi mật khẩu
        if ($user && $user->role == 1 && !$user->is_password_changed) {
            return redirect()->route('auth.password.change');
        }

        return $next($request);
    }
}
