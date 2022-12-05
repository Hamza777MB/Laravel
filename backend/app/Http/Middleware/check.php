<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class check
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
        $vaild =false;
        $request->validate([
            'name'=>'required',
            'email'=>'required']);
     $index = expert::class::all();
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['email']==$request['email']&&$index[$i]['password']==$request['password']){
            $vaild = true;
            break;
        }
     }
     if(!$vaild){
        return response('incorrect account');
     }
        return $next($request);
    }
}
