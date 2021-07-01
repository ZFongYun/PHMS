<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/PHMS_admin/AdminLogin'); //改成『若登入後再回到登入頁面時你要跳轉』的頁面，這邊應該會在LoginController的屬性$redirectTo一樣。
        }
        return $next($request);
    }
}
