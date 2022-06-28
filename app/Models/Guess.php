<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Properties
 * @property int $id
 * @property int $row
 * @property int $attempt_id
 * @property int $number_one
 * @property int $number_two
 * @property int $number_three
 * @property bool $won
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relationships
 * @property Attempt $attempt
 */
class Guess extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'row',
        'number_one',
        'number_two',
        'number_three',
        'won',
    ];

    /**
     * @return BelongsTo
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }
}
