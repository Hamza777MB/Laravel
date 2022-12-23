<?php

namespace App\Http\Controllers;

use App\Models\expert;
use App\Models\user;
use App\Models\exptype;
use App\Models\week;
use App\Models\date;
use App\Models\favorite;
use App\Models\rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExpertController extends Controller
{
    //expert functions





    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'type'=>'required'
        ]);
        $token=Hash::make($request->password);
        if($request->input('type')>5||$request->input('type')<1){
            return response()->json(['failed'=>'wrong type value']) ;
               }
        $exp =expert::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password,
        'details'=>$request->details,
        'number'=>$request->number,
        'address'=>$request->address,
        'rating'=>0,
        'rate_num'=>0,
        'wallet'=>0,
        'token'=>$token]);
        exptype::create([
            'exp_id'=>$exp['id'],
            'type'=>$request->type
        ]);
        week::create([
            'exp_id'=>$exp['id']
        ]);
if($request->has('photo')){
        $request->validate([
            'photo' =>  'image'
        ]);
        $photo = $request->photo;
        $newPhoto = time().$request->name.'.jpg';
        $photo->move('photos',$newPhoto);
        $exp->update([
        'photo'=>'photos/'.$newPhoto]);
    }

         return response()->json(['success'=>'you signed up and logged in successfully','token'=>$token]) ;
    }






    public function index($type)
    {
        if($type<1||$type>5){

     return response()->json(['failed'=>'wrong type value']) ;
        }
        $vaild = false;
        $j=0;
     $index = exptype::all();
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['type']==$type){
            $id=$index[$i]['exp_id'];
            $index2 = expert::where('id' , $id )->first();
            $array [$j]=['id'=>$index2['id'],'name'=>$index2['name'],'email'=>$index2['email'],'details'=>$index2['details'],
        'number'=>$index2['number'],'photo'=>$index2['photo'],'address'=>$index2['address']];
            $vaild = true;
            $j++;
        }
    }
        if(!$vaild){
            return response()->json(['404'=>'not found'],404) ;
        }
        return $array;
    }






    public function search($name)
    {
     $vaild = false;
        $j=0;
     $show = expert::all();
     for ($i = 0 ; $i<count($show);$i++){
        if($show[$i]['name']==$name){
            $array [$j]=['id'=>$show[$i]['id'],'name'=>$show[$i]['name'],'email'=>$show[$i]['email'],'details'=>$show[$i]['details'],
        'number'=>$show[$i]['number'],'photo'=>$show[$i]['photo'],'address'=>$show[$i]['address']];
            $vaild = true;
            $j++;
        }
     }
     if(!$vaild){
         return response()->json(['404'=>'not found'],404) ;
     }
     return $array;
    }







    public function show($id){

        $vaild = false;
        $show = expert::where('id' , $id )->first();
        if(!$show){
            return response()->json(['404'=>'not found'],404) ;
        }
        $rate =$this->ratings($show['id']);
        $num =$this->ratings_num($show['id']);
        $index = exptype::where('exp_id' , $id )->first();
        $j=0;
            $array=['id'=>$show['id'],'name'=>$show['name'],'email'=>$show['email'],'photo'=>$show['photo'],'details'=>$show['details'],
        'number'=>$show['number'],'address'=>$show['address'],'type'=>$index['type'],'rate'=> $rate
        ,'rate_num'=>$num];
            $j++;
        return $array ;

    }



    public function showexptime($id){

        $expert = expert::where('id' , $id )->first();
        if(!$expert){
            return response()->json(['404'=>'not found'],404) ;
        }
               $start=$expert['start_hour'];
               $end=$expert['end_hour'];
               $day = week::where('exp_id' , $id )->first();
               $array=['sat'=>$day['sat'],'sun'=>$day['sun'],'mon'=>$day['mon'],'tus'=>$day['tus'],
               'wed'=>$day['wed'],'thu'=>$day['thu'],'fri'=>$day['fri']];

        return response()->json(['start hour'=>$start,'end hour'=>$end,'expert week'=>$array]) ;

    }






    public function newtype(Request $request)
    {
        $request->validate([
            'type'=>'required'
        ]);

        if ($request->type<1||$request->type>5){

            return response()->json('invailed type') ;
        }
        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();

        $show = exptype::all();
        for ($i = 0 ; $i<count($show);$i++){
           if($show[$i]['exp_id']==$expert['id']){
            if($show[$i]['type']==$request->type){
                return response()->json(['failed'=>'the type is already exist']) ;
            }
           }
        }
        exptype::create([
            'exp_id'=>$expert['id'],
            'type'=>$request->type
        ]);
         return response()->json(['success'=>'expert edited successflly']) ;
    }



    public function edit(Request $request)
    {

        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();
        if ($request->has('details')) {
            $expert->update([
                'details'=>$request->details
            ]);
    }
        if ($request->has('number')) {
            $expert->update([
                'number'=>$request->number
            ]);
    }
        if ($request->has('address')) {
            $expert->update([
                'address'=>$request->address
            ]);
    }
if($request->has('photo')){
        $request->validate([
            'photo' =>  'image'
        ]);
        $photo = $request->photo;
        $newPhoto = time().$expert['name'].'.jpg';
        $photo->move('photos',$newPhoto);
        $expert->update([
        'photo'=>'photos/'.$newPhoto]);
    }
         return response()->json(['success'=>'expert edited successflly']) ;
    }




    public function delete(Request $request)
    {

        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();
        $week = week::where('exp_id' , $expert['id']);
        $exptype = exptype::where('exp_id' , $expert['id']);
        $date = date::where('exp_id' , $expert['id']);
        $fav = favorite::where('exp_id' , $expert['id']);
        $rate = rating::where('exp_id' , $expert['id']);
        $expert->delete();
        $week->delete();
        $exptype->delete();
        $date->delete();
        $fav->delete();
        $rate->delete();
        return response()->json(['success'=>'expert deleted successflly']) ;
    }







    public function all()
    {
     $index = expert::all();
     for ($i = 0 ; $i<count($index);$i++){
        $array [$i]=['id'=>$index[$i]['id'],'name'=>$index[$i]['name'],'email'=>$index[$i]['email'],'details'=>$index[$i]['details'],
    'number'=>$index[$i]['number'],'address'=>$index[$i]['address']];
     }
     return $array;
    }




    public function exptime(Request $request){

        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();
        $week = week::where('exp_id' , $expert['id'])->first();

        if ($request->start_hour!=null||$request->end_hour!=null)
        {
            $start = strtotime($request->start_hour);
            $end = strtotime($request->end_hour);
            if (date('H:i',$start)>=date('H:i',$end))
            {
                return response(['failed'=>'the start hour is after the end hour']);
            }
        $expert->update([
            'start_hour'=>$request->start_hour,
            'end_hour'=>$request->end_hour
        ]);
        }

        if ($request->sat){
            $week->update([
                "sat"=>'Sat'
            ]);
        }


        if ($request->sun){
            $week->update([
                "sun"=>'Sun'
            ]);
        }

        if ($request->mon){
            $week->update([
                "mon"=>'Mon'
            ]);
        }

        if ($request->tue){
            $week->update([
                "tue"=>'Tue'
            ]);
        }

        if ($request->wed){
            $week->update([
                "wed"=>'Wed'
            ]);
        }

        if ($request->thu){
            $week->update([
                "thu"=>'Thu'
            ]);
        }

        if ($request->fri){
            $week->update([
                "fri"=>'Fri'
            ]);
        }

        ///////////////////////

        if ($request->sat==0){
            $week->update([
                "sat"=>null
            ]);
        }


        if ($request->sun==0){
            $week->update([
                "sun"=>null
            ]);
        }

        if ($request->mon==0){
            $week->update([
                "mon"=>null
            ]);
        }

        if ($request->tue==0){
            $week->update([
                "tue"=>null
            ]);
        }

        if ($request->wed==0){
            $week->update([
                "wed"=>null
            ]);
        }

        if ($request->thu==0){
            $week->update([
                "thu"=>null
            ]);
        }

        if ($request->fri==0){
            $week->update([
                "fri"=>null
            ]);
        }

         return response()->json(['success'=>'expert time edited successflly']) ;

    }





    public function exp_rating(Request $request){

        $token = $request->bearerToken();
        $expert = expert::where('token' , $token)->first();
        if(!$expert){
            return response()->json(['404'=>'not found'],404) ;
        }
        $rate =$this->ratings($expert['id']);
        $num =$this->ratings_num($expert['id']);
        return response()->json(['my rate'=>$rate,'number of ratings'=>$num]);


    }


    // public function allrating($id){

    //     $expert = expert::where('id' , $id)->first();
    //     if(!$expert){
    //         return response()->json(['404'=>'not found'],404) ;
    //     }
    //     $rate =$this->ratings($id);
    //     $num =$this->ratings_num($id);
    //     return response()->json(['rate'=>$rate,'number of ratings'=>$num]);
    // }




    public function ratings($id){

        $expert = expert::where('id' , $id)->first();
        $vaild = false;
        $rate=0;
        $num=0;
     $index = rating::all();
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['exp_id']==$expert['id']){
            $num=$num+1;
            $rate=($rate+$index[$i]['rate'])/$num;
            $vaild = true;
        }
    }
            $expert->update([
            'rating'=>$rate,
            'rate_num'=>$num
            ]);
        return $rate;
    }



    public function ratings_num($id){

        $expert = expert::where('id' , $id)->first();
        $vaild = false;
        $num=0;
     $index = rating::all();
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['exp_id']==$expert['id']){
            $num=$num+1;
            $vaild = true;
        }
    }
        return $num;
    }




        //trash.......................................................................................................
    public function hello(Request $request){
            $id = $request->input('id');
            $id =$this->hi($id);
            return response()->json(['dada',$id]);
    }
    public function hi($id){

        $id = 3;
        return $id;
    }
    public function e(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if(!$email||!$password)
        {
        return;
        }
        $json= json_encode(['email'=>$email,'password'=>$password]);
        $encode=base64_encode($json);
        return $encode;
    }
    public function d(Request $request){
        $json = $request->input('token');
        $decode= base64_decode($json);
        return $decode;
    }




    public function h(Request $request){
        return redirect()->route('exp.index',['type'=>2]);
    }


    public function hj(Request $request){
        $token = $request->bearerToken();

        $json = $request->input('date');

        $time = strtotime($json);

        //$j=date('Y/m/d D H:i',$time);

        $j=date('H:i',$time);
        $d=date('D',$time);
        //$j=Hash::make($json);

        $jj=strval($j);
        return response($d);
    }

}
