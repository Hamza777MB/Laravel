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
        $vaild =false;
        $pass=false;
        $request->validate([
            'password'=>'required',
            'email'=>'required']);
     $index = expert::all();
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['email']==$request['email']){
            $vaild = true;
            if($index[$i]['password']==$request['password']){
                $pass=true;}
                if(!$pass){
                    return response()->json(['status'=>'incorrect password'],404);
                 }
            break;
        }
     }
     if(!$vaild){
        $index2 = user::all();
        $pass=false;
        for ($i = 0 ; $i<count($index2);$i++){
           if($index2[$i]['email']==$request['email']){
               $vaild = true;
               if($index2[$i]['password']==$request['password']){
                $pass=true;}
                if(!$pass){
                    return response()->json(['status'=>'incorrect password'],404);
                 }
               break;
           }
        }
        if(!$vaild){
           return response()->json(['status'=>'incorrect account'],404);
        }

     }
     return $next($request);
    }
}
