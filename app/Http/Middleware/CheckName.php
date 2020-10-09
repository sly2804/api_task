<?php

namespace App\Http\Middleware;

use Closure;
use http\Env\Response;

class CheckName
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
        if (mb_strlen(trim($request->input('name')))<2){
            return response()->json(['status' => 'Task not created','error'=>'Name must consist of 2 or more characters']);
        }
        return $next($request);
    }
}
