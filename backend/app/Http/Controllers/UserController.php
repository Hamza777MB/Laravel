<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
        {
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'password'=>'required'
            ]);
            user::create($request->all());
             return response()->json(['success'=>'user added successflly']) ;
        }
    public function delete($id)
        {
            user::find($id)->delete();
            return response()->json(['success'=>'expert deleted successflly']) ;
        }
    public function profile($id){
            $user= user::find($id);
            return $user;
        }







        //trash
    public function hello(Request $request){
            $id = $request->input('id');
            return response()->json(['dada',$id]);
        }
}
