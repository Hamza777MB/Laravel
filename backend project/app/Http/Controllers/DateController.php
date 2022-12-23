<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\expert;
use App\Models\user;
use App\Models\week;
use App\Models\exptype;
use App\Models\date;

class DateController extends Controller
{


    public function add(Request $request,$id)
    {
        $token = $request->bearerToken();
        $user = user::where('token' , $token)->first();

        if($user['wallet']<1000){

            return response(['failed'=>'you cannot make a date, you are out of money']);

        }

        $userid= $user['id'];

        $json = $request->input('date');
        $time = strtotime($json);

        $exp= expert::where('id' , $id )->first();
        if ($exp['start_hour']!=null||$exp['end_hour']!=null)
        {
        $start = strtotime($exp['start_hour']);
        $end = strtotime($exp['end_hour']);
        if (date('H:i',$time)<date('H:i',$start)||date('H:i',$time)>date('H:i',$end))
        {
            return response(['failed'=>'you cannot make a date out of expert work time']);
        }
        }

        $day=date('D',$time);
        $week= week::where('exp_id' , $id )->first();
        if($day){
        if($day==$week['sat']||$day==$week['sun']||$day==$week['mon']||$day==$week['tue']||
        $day==$week['wed']||$day==$week['thu']||$day==$week['fri']){
            return response(['failed'=>'you cannot make a date on expert offdays']);
        }
        }
        $date=date('Y/m/d D H:i',$time);

     $index = date::all();

//      $index1=date::query()->where('expert_id',$id)->get();
//      foreach($index1 as $i){
// if($i->date ==$date)
// return response('this date is already token');
//      }
     for ($i = 0 ; $i<count($index);$i++){
        if($index[$i]['exp_id']==$id){
            if($index[$i]['date']==$date)
            {
                return response(['failed'=>'this date is already exist']);
            }
        }
    }
    $add=$exp['wallet']+1000;
    $exp->update([
        'wallet'=>$add
    ]);
    $sub=$user['wallet']-1000;
    $user->update([
        'wallet'=>$sub
    ]);
        date::create([
            'user_id'=>$userid,
            'exp_id'=>$id,
            'date'=>$date
        ]);
        return response()->json(['success'=>'date added successfully']);
    }




    public function alldates($id)
    {
        $v=false;
        $index = date::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['exp_id']==$id){
            $userid[$i] = user::where('id' ,$index[$i]['user_id'] )->first();
            $array [$i]= ['name'=>$userid[$i]['name'],'date'=>$index[$i]['date']];
            $v=true;
           }
       }
       if(!$v){
       return response()->json('there is no dates to this expert',404) ;
       }
       return $array ;
    }








    public function mydates(Request $request)
    {


        $v=false;
        $token = $request->bearerToken();
        $index = user::where('token' , $token)->first();
        $id= $index['id'];

        $index = date::all();
        for ($i = 0 ; $i<count($index);$i++){
           if($index[$i]['user_id']==$id){
            $expid = expert::where('id' ,$index[$i]['exp_id'] )->first();
            $array [$i]= ['name'=>$expid['name'],'date'=>$index[$i]['date']];
            $v=true;
           }
       }
       if(!$v){
       return response()->json('there is no dates to you',404) ;
       }
       return $array ;
    }
    //
}
