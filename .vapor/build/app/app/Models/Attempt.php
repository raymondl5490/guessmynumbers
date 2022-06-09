<?php

namespace App\Models;

use App\Enums\TokenAbilities;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Properties
 * @property int $id
 * @property int $player_id
 * @property int $game_id
 * @property bool $won
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relationships
 * @property Game $game
 * @property Player $player
 * @property Guess[] $guesses
 */
class Attempt extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'game_id',
    ];

    /**
     * @return BelongsTo
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * @return HasMany
     */
    public function guesses(): HasMany
    {
        return $this->hasMany(Guess::class);
    }
}
