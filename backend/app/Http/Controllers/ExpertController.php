<?php

namespace App\Http\Controllers;

use App\Models\expert;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index($type)
    {
        $exp_type = $type ;
     $index = expert::find($exp_type)->latest()->all();
     return $index;
    }
    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'exp_type'=>'required'
        ]);
        expert::create($request->all());
         return redirect()->route('/experts/login')
         ->with('success','expert added successflly') ;
    }
    public function show($name)
    {
        $exp= expert::find($name);
        return $exp;
    }
    public function edit(Request $request,$id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'exp_type'=>'required',
        ]);

        $expert =expert::find($id);
        $expert->update($request->all());
         return response('success','expert edited successflly') ;
    }
    public function delete($id)
    {
        expert::find($id)->delete();
        return response('success','expert deleted successflly') ;
    }
    public function profile(Request $request){

        return response('success','you logged in successflly') ;


    }
    }
