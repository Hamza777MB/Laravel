<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class date extends Model
{

    //hamza

    protected $fillable = ['user_id','exp_id','date'];

    // public function user()

    // {
    //     return $this->belongsTo(user::class,'user_id');
    // }

    // public function expert()
    // {
    //     return $this->belongsTo(expert::class, 'expert_id' );
    // }
    use HasFactory;
}
