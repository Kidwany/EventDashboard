<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CompanyApproved
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
        $userApproved = Auth::user()->is_approved;
        if ($userApproved != 1)
        {
            //
            return redirect('/')->with('warning', 'هذا الحساب لم يتم تفعيله بعد ... سيتم تفعيل الحساب خلال 3 ايام عمل');
        }
        return $next($request);

    }
}
