<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\expert;
use App\Models\user;


class checktoken
{
    //hamza
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
     if(!$vaild){
        $index = user::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['token']==$token){
               $vaild = true;
               break;
                }
            }
        }
    }
    catch(\Exception $exception){
        $error = true;
    }
    if($error){
        return response()->json(['massage'=>'invaild token'],404);
    }

     if(!$vaild){
        return response()->json(['massage'=>'incorrect account'],404);
     }
        return $next($request);
    }
}













/*
class check
{
    public function handle(Request $request, Closure $next)
    {
        $error = false;
        $vaild =false;
        $id = null;
        if (!$request->hasHeader('ite')){
            $error = true;
        }
        $token = $request->header('ite');
        try{
            $json = base64_decode($token);
            $file = json_decode($json,true);
            if(!$file){
                $error = false;
            }
            if(!isset($file['email'])){
                $error = true;
            }
         $index = expert::all();
         for ($i = 0 ; $i<count($index);$i++){
            if($index[$i]['email']==$file['email']&&$index[$i]['password']==$file['password']){
                $vaild = true;
                break;
            }
        }
     if(!$vaild){
        $index = user::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['email']==$file['email']&&$index[$i]['password']==$file['password']){
               $vaild = true;
               break;
                }
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
*/
