<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\expert;
use App\Models\user;
use App\Models\exptype;
use App\Models\week;
use App\Models\date;
use App\Models\favorite;
use App\Models\rating;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //user functions
    public function createuser(Request $request)
        {
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'password'=>'required'
            ]);
            $token=Hash::make($request->password);
            user::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'wallet'=>20000,
            'token'=>$token]);
         return response()->json(['success'=>'you signed up and logged in successfully','token'=>$token]) ;
        }





    public function deleteuser(Request $request)
        {
            $token = $request->bearerToken();
            $user = user::where('token' , $token)->first();
            $date = date::where('user_id' , $user['id']);
            $fav = favorite::where('user_id' , $user['id']);
            $rate = rating::where('user_id' , $user['id']);
            $user->delete();
            $date->delete();
            $fav->delete();
            $rate->delete();
            return response()->json(['success'=>'user deleted successflly']) ;
        }


        public function addfav(Request $request,$id){

            $token = $request->bearerToken();
            $user = user::where('token' , $token)->first();
            $expert = expert::where('id' , $id)->first();
            if(!$expert){return response()->json(['error'=>'not found'],404) ;}

            $r = favorite::all();
        for ($i = 0 ; $i<count($r);$i++){
            if($r[$i]['user_id']==$user['id']){
                if($r[$i]['exp_id']==$expert['id']){
                    return response()->json(['error'=>'you cannot ad to fav twice']) ;
                }
            }
            }
            favorite::create([
                'user_id'=>$user['id'],
                'exp_id'=>$expert['id']
            ]);

            return response()->json(['success'=>'expert add to fav successflly']) ;

        }



        public function showfav(Request $request){

            $token = $request->bearerToken();
            $user = user::where('token' , $token)->first();

            $fav = favorite::all();
            $vaild = false;
            $j=0;
        for ($i = 0 ; $i<count($fav);$i++){
            if($fav[$i]['user_id']==$user['id']){
            $expert = expert::where('id' , $fav[$i]->exp_id)->first();
                $array[$j]=[$fav[$i]->exp_id,$expert->name];
                $j++;
                $vaild = true;
            }
            }


            if(!$vaild){
                return response()->json('there is no expert in fav',404) ;
                }

            return response()->json(['success'=>$array]) ;

        }



        public function deletefav(Request $request,$id){

            $token = $request->bearerToken();
            $user = user::where('token' , $token)->first();
            $expert = expert::where('id' , $id)->first();
            if(!$expert){return response()->json(['error'=>'not found'],404) ;}

            $fav = favorite::all();
            $vaild = false;
            $j=0;
        for ($i = 0 ; $i<count($fav);$i++){
            if($fav[$i]['user_id']==$user['id']){
                if($fav[$i]['exp_id']==$id){
                    $fav[$i]->delete();
                    $vaild = true;
                    break;
                }
            }
            }

       if(!$vaild){
        return response()->json('there is no expert in fav with such an id',404) ;
        }
            return response()->json(['success'=>'expert deleted from fav successflly']) ;

        }














        public function addrate(Request $request,$id){
            if($request->rate<0||$request->rate>5){

         return response()->json('wrong rate value') ;
            }

            $token = $request->bearerToken();
            $user = user::where('token' , $token)->first();
            $expert = expert::where('id' , $id)->first();
            if(!$expert){return response()->json(['error'=>'not found'],404) ;}



            $r = rating::all();
        for ($i = 0 ; $i<count($r);$i++){
            if($r[$i]['user_id']==$user['id']){
                if($r[$i]['exp_id']==$id){
                    return response()->json(['error'=>'you cannot rate twice']) ;
                }
            }
            }
            rating::create([
                'user_id'=>$user['id'],
                'exp_id'=>$expert['id'],
                'rate'=>$request->rate
            ]);
            return response()->json(['success'=>'expert rated successflly']) ;

        }



        public function editrate(Request $request,$id){
            if($request->rate<0||$request->rate>5){

         return response()->json('wrong rate value') ;
            }

            $token = $request->bearerToken();
            $user = user::where('token' , $token)->first();
            $expert = expert::where('id' , $id)->first();
            if(!$expert){return response()->json(['error'=>'not found'],404) ;}


            $vaild = false;
         $index = rating::all();
         for ($i = 0 ; $i<count($index);$i++){
            if($index[$i]['user_id']==$user['id']){
                if($index[$i]['exp_id']==$expert['id']){
                $index[$i]->update(["rate"=>$request->rate]);
                $vaild = true;}
            }
        }
            if(!$vaild){
                return response()->json(['404'=>'not found'],404) ;
            }
            return response()->json(['success'=>'rating updated successflly']) ;

        }





        public function myrate(Request $request,$id){

            $token = $request->bearerToken();
            $user = user::where('token' , $token)->first();
            $expert = expert::where('id' , $id)->first();
            if(!$expert){return response()->json(['error'=>'not found'],404) ;}


            $rate=null;
            $vaild = false;
         $index = rating::all();
         for ($i = 0 ; $i<count($index);$i++){
            if($index[$i]['user_id']==$user['id']){
                if($index[$i]['exp_id']==$expert['id']){
                $rate=$index[$i]['rate'];
                $vaild = true;}
            }
        }
            if(!$vaild){
                return response()->json(['404'=>'not found'],404) ;
            }
            return response()->json(['my rate'=>$rate]) ;

        }






    //
}
