<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\expert;
use App\Models\user;
use App\Models\exptype;
use App\Models\week;
use App\Models\date;
use App\Models\favorite;
use Illuminate\Support\Facades\Hash;
class auth extends Controller
{

    public function login(Request $request)
    {

        $token=Hash::make($request->password);
        $index = expert::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['email']==$request['email']){
            $id=$index[$i]['id'];
            $exp= expert::where('id' , $id )->first();
            $exp->update([ 'token'=>$token]);
            return response()->json(['acssess type'=>'expert','token'=>$token]) ;
           }
        }
        $index2 = user::all();
        for ($i = 0 ; $i<count($index2);$i++){
           if($index2[$i]['email']==$request['email']){
            $id=$index2[$i]['id'];
            $user= user::where('id' , $id )->first();
            $user->update([ 'token'=>$token]);
            return response()->json(['acssess type'=>'user','token'=>$token]) ;
           }
        }
         return response()->json(['success'=>'you logged in successfully','token'=>$token]) ;
    }


    public function profile(Request $request)
    {

        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();
        $user = user::where('token' , $token)->first();
        if(!$user){
        $show=$expert;
        $password= base64_encode($show['password']);

            $array=['id'=>$show['id'],'name'=>$show['name'],'email'=>$show['email'],'encoded password'=>$password,'details'=>$show['details'],
        'number'=>$show['number'],'address'=>$show['address'],'wallet'=>$show['wallet']];

         return $array ;
               }

        if(!$expert){
            $show=$user;
            $password= base64_encode($show['password']);
            $array=['id'=>$show['id'],'name'=>$show['name'],'email'=>$show['email'],'encoded password'=>$password,'wallet'=>$show['wallet']];
         return $array ;
                   }
         return ;
    }



    public function logout(Request $request){

        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();

        if($expert){
        $expert->update([
            'token'=>null
        ]);}
        if(!$expert){
        $user = user::where('token' , $token)->first();
        if($user){
        $user->update(['token'=>null]);}

        }
        return response()->json('you logged out successfuly') ;
    }




    public function wallet(Request $request)
    {
        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();
        $user = user::where('token' , $token)->first();
        if(!$user){
            $wallet=$expert['wallet'];
            return response()->json(['my money'=>$wallet.'$']) ;
               }

        if(!$expert){
            $wallet=$user['wallet'];

            return response()->json(['my money'=>$wallet]) ;
                   }
         return ;
    }



    public function cash(Request $request)
    {
///hazma

        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();
        $user = user::where('token' , $token)->first();
        $sum = $request->cash;
        if(!$user){
            $wallet=$expert['wallet']+$sum;
            $expert->update([
            'wallet'=> $wallet
            ]);
            return response()->json('money added successfuly') ;
               }

        if(!$expert){
            $wallet=$user['wallet']+$sum;
            $user->update([
                'wallet'=> $wallet
                ]);
            return response()->json('money added successfuly') ;
                   }
         return ;

    }

    //
}
