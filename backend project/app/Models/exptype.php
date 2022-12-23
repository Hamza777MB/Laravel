<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exptype extends Model
{


    protected $fillable = ['exp_id','type'];

    // public function expert()
    // {
    //     return $this->belongsTo('App\Models\expert', 'exp_id' );
    // }
    use HasFactory;
}
