<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Federation Model
 *
 * Represents a darts federation (e.g., FFD - Fédération Française de Darts).
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Club> $clubs
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 */
class Federation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Mass assignment security strategy:
     * - All fields are fillable as they will be validated via Form Requests in Story 3.2+
     * - No sensitive/computed fields exist on this model
     * - Future endpoints MUST use Form Request validation before mass assignment
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'country',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    /**
     * Get the clubs associated with this federation.
     */
    public function clubs(): HasMany
    {
        return $this->hasMany(Club::class);
    }

    /**
     * Get the players associated with this federation.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}
