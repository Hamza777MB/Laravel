<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExpertController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\auth;

//auth
route::post('/login',[auth::class,'login'])->middleware(['check'])->name('login');
route::get('/myprofile',[auth::class,'profile'])->middleware(['checktoken']);
route::get('/logout',[auth::class,'logout'])->middleware(['checktoken'])->name('logout');

//expert
route::post('/experts/signup',[ExpertController::class,'create'])->middleware(['checkifexist'])->name('exp.signup');
route::get('/experts/index/{type}',[ExpertController::class,'index'])->name('exp.index');
route::get('/experts/search/{name}',[ExpertController::class,'search'])->name('exp.search');
route::get('/experts/show/{id}',[ExpertController::class,'show'])->name('exp.show2');
route::get('/experts/showtime/{id}',[ExpertController::class,'showexptime'])->name('exp.showtime');
route::get('/experts/all',[ExpertController::class,'all'])->name('exp.all');
route::post('/experts/addtype',[ExpertController::class,'newtype'])->middleware(['checkexpert'])->name('exp.type');
route::post('/experts/edittime',[ExpertController::class,'exptime'])->middleware(['checkexpert']);
route::post('/experts/edit',[ExpertController::class,'edit'])->middleware(['checkexpert'])->name('exp.edit');
route::delete('/experts/delete',[ExpertController::class,'delete'])->middleware(['checkexpert'])->name('exp.delete');


//dates
route::post('users/add/date/{id}',[DateController::class,'add'])->middleware(['checkuser']);
route::get('experts/all/date/{id}',[DateController::class,'alldates']);
route::get('users/date',[DateController::class,'mydates'])->middleware(['checkuser']);

//user
route::post('/users/signup',[UserController::class,'createuser'])->middleware(['checkifexist'])->name('user.signup');
route::delete('/users/delete',[UserController::class,'deleteuser'])->middleware(['checkuser'])->name('user.delete');

//fav
route::post('/users/addfav/{id}',[UserController::class,'addfav'])->middleware(['checkuser']);
route::get('/users/showfav',[UserController::class,'showfav'])->middleware(['checkuser']);
route::delete('/users/deletefav/{id}',[UserController::class,'deletefav'])->middleware(['checkuser']);


//rate
route::post('/users/addrate/{id}',[UserController::class,'addrate'])->middleware(['checkuser']);
route::post('/users/editrate/{id}',[UserController::class,'editrate'])->middleware(['checkuser']);
route::get('/users/myrate/{id}',[UserController::class,'myrate'])->middleware(['checkuser']);
route::get('/experts/myratings',[ExpertController::class,'exp_rating'])->middleware(['checkexpert']);

//wallet

route::post('/addcash',[auth::class,'cash'])->middleware(['checktoken']);
route::get('/mywallet',[auth::class,'wallet'])->middleware(['checktoken']);



///hamza







//trash......................................................................................................................................
route::get('/hi',[ExpertController::class,'hi'])->name('hi');
route::post('/hello',[ExpertController::class,'hello']);
route::get('/e',[ExpertController::class,'e'])->name('e');
route::get('/d',[ExpertController::class,'d'])->name('d');

route::get('/h',[ExpertController::class,'h'])->name('h');
route::post('/hj',[ExpertController::class,'hj'])->name('hj');




