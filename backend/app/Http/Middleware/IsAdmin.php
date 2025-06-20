<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Giả sử user có cột 'is_admin' trong bảng users
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
