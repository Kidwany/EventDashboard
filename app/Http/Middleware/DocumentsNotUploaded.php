<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DocumentsNotUploaded
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
        $userApproved = Auth::user()->is_docs_uploaded;
        if ($userApproved == null && $userApproved != 0)
        {
            return redirect('/complete-register')->with('warning', 'من فضلك قم بإستكمال عملية التسجيل');
        }
        return $next($request);
    }
}
