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
        $id = null;
        $request->validate([
            'password'=>'required',
            'email'=>'required']);
     $index = expert::all();
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['email']==$request['email']&&$index[$i]['password']==$request['password']){
            $vaild = true;
            break;
        }
     }
     if(!$vaild){
        $index2 = user::all();
        for ($i = 0 ; $i<count($index2);$i++){
           if($index2[$i]['email']==$request['email']&&$index2[$i]['password']==$request['password']){
               $vaild = true;
               break;
           }
        }
        if(!$vaild){
           return response()->json('incorrect account');
        }
     }
     return $next($request);
    }
}
