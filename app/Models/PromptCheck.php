<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromptCheck extends Model
{
    /** @use HasFactory<\Database\Factories\PromptCheckFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
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
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
