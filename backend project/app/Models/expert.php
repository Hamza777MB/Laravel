<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expert extends Model
{
    protected $fillable = ['name','email','password','photo','details','number','address','start_hour','end_hour','token','wallet','rating','rate_num'];

    // public function expertdate()
    // {
    //     return $this->hasMany(date::class);
    // }
    use HasFactory;
}
