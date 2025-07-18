<?php

declare(strict_types = 1);

namespace Centrex\Messages\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, MorphTo};
use Illuminate\Support\Collection;

final class Message extends Model
{
    use SoftDeletes;

    protected $table = 'messages';

    protected $touches = ['thread'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    private array $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function creator(): MorphTo
    {
        return $this->morphTo('creator');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class, 'thread_id', 'thread_id');
    }

    public function recipients(): Collection
    {
        return $this->participants()
            ->where('participant_id', '!=', $this->participant_id)
            ->where('participant_type', '!=', $this->participant_type);
    }
}
