<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Properties:
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relationships:
 * @property Attempt[] $attempts
 * @property Guess[] $guesses
 */
class Player extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }

    /**
     * @return HasManyThrough
     */
    public function guesses(): HasManyThrough
    {
        return $this->hasManyThrough(Guess::class, Attempt::class);
    }
}
