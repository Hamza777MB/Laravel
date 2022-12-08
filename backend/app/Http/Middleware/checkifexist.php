<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\expert;

class checkifexist
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
        $index = expert::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['email']==$request['email']){
            return response()->json(['faild'=>'email already exist']);
           }}

        $index2 = user::all();
        for ($i = 0 ; $i<count($index2);$i++){
           if($index2[$i]['email']==$request['email']){
            return response()->json(['faild'=>'email already exist']);
           }}
        return $next($request);
    }
}
