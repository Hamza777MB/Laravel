<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    protected $fillable = ['name','email','password','wallet','token'];



    // public function userdate(){

    //     return $this->hasMany(date::class);

    // }
    use HasFactory;
}
