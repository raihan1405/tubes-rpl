<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if((Auth::user()->role == 'admin'||Auth::user()->role == 'developer')&&Auth::user()->status == 'approved'){
                return $next($request);
            }else{
                if ($request->ajax()) {
                    return response()->json(['error' => 'Access denied'], 403);
                } else {
                    return redirect('/')->with('warning', 'Status kamus belum di approved');
                }
            }

        }else{
            return redirect('/login')->with('warning','Silahkan Login');
        }

        return $next($request);
    }
}

