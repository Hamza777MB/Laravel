<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expert extends Model
{
    protected $fillable = ['name','email','password','photo','details','type','number','address','availble'];
    use HasFactory;
}
