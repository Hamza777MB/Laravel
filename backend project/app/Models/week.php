<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class week extends Model
{
    protected $fillable = ['exp_id','sat','sun','mon','tue','wed','thu','fri'];

    use HasFactory;
}
