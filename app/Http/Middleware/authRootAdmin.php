<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use http\Env\Request;
use Symfony\Component\HttpFoundation\Response;

class authRootAdmin
{
    /**
     * Handle an incoming request.
     *
     * //     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->exists('sessionSignature')) {
            return $next($request);
        } else {
            $request->session()->flush();
            Auth::logout();
            return redirect('/')->with('error', 'Session Expired');
        }
    }
}
