<?php

declare(strict_types = 1);

namespace Centrex\Messages\Models;

use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphTo};
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

final class Participant extends Model
{
    use SoftDeletes;

    protected $table = 'participants';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'last_read'];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function model(): Morphto
    {
        return $this->morphTo('participant');
    }
}
