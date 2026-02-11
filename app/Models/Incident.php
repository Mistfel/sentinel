<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'severity',
        'status',
        'prompt_snapshot',
        'prompt_check_id',
        'notes',
    ];

    /**
     * @return BelongsTo<PromptCheck, $this>
     */
    public function promptCheck(): BelongsTo
    {
        return $this->belongsTo(PromptCheck::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
