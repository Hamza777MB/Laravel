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
             return redirect()->route('/users/login')
             ->with('success','user added successflly') ;
        }
        public function delete($id)
        {
            user::find($id)->delete();
            return response('success','expert deleted successflly') ;
        }
        public function profile(Request $request){

            return response('success','you logged in successflly') ;
        }
    //
}
