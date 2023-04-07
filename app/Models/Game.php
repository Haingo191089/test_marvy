<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

use Database\Factories\GameFactory;

use App\Models\Score;

class Game extends Model
{
    use HasFactory;

    public const ID_COL = 'id';
    public const NAME_COL = 'name';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::NAME_COL,
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return GameFactory::new();
    }

    /**
     * Get the scores for the user.
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
