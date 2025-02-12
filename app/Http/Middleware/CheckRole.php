<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role; // Thêm dòng này để import class Role


class CheckRole
{

    /**
     * Xử lý yêu cầu và kiểm tra quyền truy cập.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, $role)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->hasRole($role)) {
            // abort(403);
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }
        return $next($request);
    }
}
