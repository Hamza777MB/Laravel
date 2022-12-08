<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\expert;
use App\Models\user;
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
            if($index[$i]['email']==$file['email']&&$index[$i]['password']==$file['email']){
                $vaild = true;
                break;
            }
        }
     if(!$vaild){
        $index = user::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['email']==$file['email']&&$index[$i]['password']==$file['email']){
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
