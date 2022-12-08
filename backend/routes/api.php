<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExpertController;
use App\Http\Controllers\UserController;

//expert
route::post('/experts/signup',[ExpertController::class,'create'])->middleware(['checkifexist'])->name('exp.signup');
route::get('/login',[ExpertController::class,'profile'])->middleware(['check'])->name('exp.login');
route::get('/experts/index/{type}',[ExpertController::class,'index'])->name('exp.index');
route::get('/experts/show/{name}',[ExpertController::class,'show'])->name('exp.show');
route::get('/experts/show2/{id}',[ExpertController::class,'show2'])->name('exp.show2');
route::get('/experts/all/',[ExpertController::class,'all'])->name('exp.all');

//user
route::post('/users/signup',[ExpertController::class,'create2'])->middleware(['checkifexist'])->name('user.signup');













//trash......................................................................................................................................
route::get('/hello',[UserController::class,'hello'])->name('hello');
route::get('/hi',[ExpertController::class,'hi'])->name('hi');
route::get('/e',[ExpertController::class,'e'])->name('e');
route::get('/d',[ExpertController::class,'d'])->name('d');

route::get('/h',[ExpertController::class,'h'])->name('h');







route::delete('/users/delete/{id}',[ExpertController::class,'delete2'])->name('user.delete');

route::post('/experts/edit/{id}',[ExpertController::class,'edit'])->middleware(['check'])->name('exp.edit');
route::delete('/experts/delete/{id}',[ExpertController::class,'delete'])->middleware(['check'])->name('exp.delete');
