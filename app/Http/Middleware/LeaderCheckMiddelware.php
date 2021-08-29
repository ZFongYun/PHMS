<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;

class LeaderCheckMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $member_id = auth('member')->user()->id;
        $member_title = Member::where('id',$member_id)->pluck('title');

        if ($member_title[0] != 2) {
            echo "<script>alert('無權限新增。')</script>";
            echo back();
        }
        return $next($request);
    }
}
