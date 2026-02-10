<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromptCheck extends Model
{
    /** @use HasFactory<\Database\Factories\PromptCheckFactory> */
    use HasFactory;

    protected $fillable = [
        'prompt',
        'purpose',
        'sensitivity',
        'result',
        'score',
        'reasons',
        'meta',
    ];

    /**
     * @return HasMany<Incident, $this>
     */
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reasons' => 'array',
            'meta' => 'array',
        ];
    }
}
