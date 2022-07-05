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

    /**
     * Number of attempts of this player.
     *
     * @return int
     */
    public function getNumberOfAttemptsAttribute()
    {
        $numberOfAttempts = Attempt::where('player_id', $this->id)
            ->count();
        return $numberOfAttempts;
    }

    /**
     * Number of wons of this player.
     *
     * @return int
     */
    public function getNumberOfWonsAttribute()
    {
        $numberOfWons = Attempt::where('player_id', $this->id)
            ->where('won', 1)
            ->count();
        return $numberOfWons;
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['number_of_attempts', 'number_of_wons'];
}
