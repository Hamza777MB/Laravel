<?php

namespace App\Http\Controllers;

use App\Models\expert;
use App\Models\user;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    //expert functions



    public function index($type)
    {
        if($type<1||$type>6){

     return response()->json('wrong type value') ;
        }
        $vaild = false;
     $index = expert::all();
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['type']==$type){
            $array [$i][0]=$index[$i]['id'];
            $array [$i][1]=$index[$i]['name'];
            $array [$i][2]=$index[$i]['email'];
            $array [$i][3]=$index[$i]['details'];
            $array [$i][4]=$index[$i]['number'];
            $array [$i][5]=$index[$i]['address'];
            $array [$i][6]=$index[$i]['availble'];
            $vaild = true;
        }
        if(!$vaild){
            return response()->json(['404'=>'not found'],404) ;
        }
     }
     return response()->json($array) ;
    }



    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'type'=>'required'
        ]);
        if($request->input('type')>6||$request->input('type')<1){

            return response()->json('wrong type value') ;
               }
        expert::create($request->all());
         return response()->json(['success'=>'expert added successflly']) ;
    }





    public function profile(Request $request)
    {
        $index = expert::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['email']==$request['email']){
            $id=$index[$i]['id'];
            $exp= expert::find($id);
            return response()->json(['expert'=>$exp]) ;
           }
        }
        $index2 = user::all();
        for ($i = 0 ; $i<count($index2);$i++){
           if($index2[$i]['email']==$request['email']){
            $id=$index2[$i]['id'];
            $user= user::find($id);
            return response()->json(['user'=>$user]) ;
           }
        }
        return;
    }






    public function show($name)
    {
     $vaild = false;
     $show = expert::all();
     for ($i = 0 ; $i<count($show);$i++){
        if($show[$i]['name']==$name){
            $array [$i][0]=$show[$i]['id'];
            $array [$i][1]=$show[$i]['name'];
            $array [$i][2]=$show[$i]['email'];
            $array [$i][3]=$show[$i]['details'];
            $array [$i][4]=$show[$i]['number'];
            $array [$i][5]=$show[$i]['address'];
            $array [$i][6]=$show[$i]['availble'];
            $vaild = true;
        }
     }
     if(!$vaild){
         return response()->json(['404'=>'not found'],404) ;
     }
     return response()->json($array) ;
    }







    public function show2($id){

        $vaild = false;
        $show = expert::all();
        for ($i = 0 ; $i<count($show);$i++){
           if($show[$i]['id']==$id){
               $array [0]=$show[$i]['id'];
               $array [1]=$show[$i]['name'];
               $array [2]=$show[$i]['email'];
               $array [3]=$show[$i]['details'];
               $array [4]=$show[$i]['number'];
               $array [5]=$show[$i]['address'];
               $array [6]=$show[$i]['availble'];
               $vaild = true;
           }
        }
        if(!$vaild){
            return response()->json(['404'=>'not found'],404) ;
        }
        return response()->json($array) ;

    }


















    public function edit($id,Request $request)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required',
        ]);
        $expert =expert::find($id);
        $expert->update($request->all());
         return response()->json('success','expert edited successflly') ;
    }





    public function delete($id,Request $request)
    {
        expert::find($id)->delete();
        return response()->json('success','expert deleted successflly') ;
    }







    public function all()
    {
     $index = expert::all();
     for ($i = 0 ; $i<count($index);$i++){
            $array [$i][0]=$index[$i]['id'];
            $array [$i][1]=$index[$i]['name'];
            $array [$i][2]=$index[$i]['email'];
            $array [$i][3]=$index[$i]['details'];
            $array [$i][4]=$index[$i]['number'];
            $array [$i][5]=$index[$i]['address'];
            $array [$i][6]=$index[$i]['availble'];
            $array [$i][7]=$index[$i]['type'];
     }
     return response()->json($array) ;
    }


    //user functions
    public function create2(Request $request)
        {
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'password'=>'required'
            ]);
            user::create($request->all());
             return response()->json(['success'=>'user added successflly']) ;
        }





    public function delete2($id)
        {
            user::find($id)->delete();
            return response()->json(['success'=>'expert deleted successflly']) ;
        }











        //trash.......................................................................................................
    public function hello(Request $request){
            $id = $request->input('id');
            return response()->json(['dada',$id]);
    }
    public function hi(Request $request){
        $id = $request->input('id');
        return response()->json(['mama',$id]);
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
}
