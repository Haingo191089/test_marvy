<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\Factory;

use Database\Factories\ScoreFactory;

use App\Models\User;
use App\Models\Game;

class Score extends Model
{
    use HasFactory;

    public const ID_COL = 'id';
    public const SCORE_COL = 'score';
    public const USER_ID_COL = 'user_id';
    public const GAME_ID_COL = 'game_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::SCORE_COL,
        self::USER_ID_COL,
        self::GAME_ID_COL,
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ScoreFactory::new();
    }

    /**
     * Get the user that owns the score.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game that owns the score.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
