<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\user;
class checkuser
{
    public function handle(Request $request, Closure $next)
    {
        $vaild =false;
        $id = null;
        $request->validate([
            'password'=>'required',
            'email'=>'required']);
        $index2 = user::all();
        for ($i = 0 ; $i<count($index2);$i++){
           if($index2[$i]['email']==$request['email']&&$index2[$i]['password']==$request['password']){
               $vaild = true;
               $id=$index2[$i]['id'];
               break;
           }
        }
        if(!$vaild){
           return response()->json('incorrect account');
        }
        return $next($request);
    }
}
