<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class websockets
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
       $token = $request->header('email');
       if(empty($token)){
           return response()->json(['message'=>'Authentication header is missing.'],401);
       }
       $user = User::where('email',$token)->first();
       if(empty($user)){
            return response()->json(['message'=>'Invalid authentication token provided.'],401);
       }
       $next($request);
    }
}
