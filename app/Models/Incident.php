<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'title','category','severity','status','prompt_snapshot','prompt_check_id','notes',
    ];
}
