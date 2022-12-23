<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\expert;

class checkexpert
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
        $error = false;
        $vaild =false;
        $id = null;
        if (!$request->hasHeader('Authorization')){
            $error = true;
        }
        $token = $request->bearerToken();
        try{
            if(!$token){
                $error = false;
            }
         $index = expert::all();
         for ($i = 0 ; $i<count($index);$i++){
            if($index[$i]['token']==$token){
                $vaild = true;
                break;
            }
        }
    }
    catch(\Exception $exception){
        $error = true;
    }
    if($error){
        return response()->json(['massage'=>'invaild token']);
    }

     if(!$vaild){
        return response()->json(['massage'=>'incorrect account']);
     }
        return $next($request);
    }
}
