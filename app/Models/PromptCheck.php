<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptCheck extends Model
{
    protected $fillable = [
        'prompt','purpose','sensitivity','result','score','reasons','meta',
    ];

    protected $casts = [
        'reasons' => 'array',
        'meta' => 'array',
    ];
}
