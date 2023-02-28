<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            $permissions = auth()->user()->permissions;
            if(auth()->user()->tokenCan([$permissions]))
            {   
                return $next($request);
            }
            else
            {
                return response()->json([
                    'message'=>'acess denied..'
            ],403);
            }
        }else{
            return response()->json([
                'status'=>401,
                'message'=>"Faça login primeiro",
            ]);
        }
        return $next($request);
    }
}
