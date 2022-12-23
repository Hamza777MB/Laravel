<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{

    protected $fillable = ['user_id','exp_id','rate'];
    use HasFactory;
}
