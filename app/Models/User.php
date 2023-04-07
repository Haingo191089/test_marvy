<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\Factory;

use Database\Factories\UserFactory;

use App\Models\Score;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ID_COL = 'id';
    public const NAME_COL = 'name';
    public const PHONE_NUMBER_COL = 'phone_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::NAME_COL,
        self::PHONE_NUMBER_COL,
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * Get the scores for the user.
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
