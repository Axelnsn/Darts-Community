<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Club Model
 *
 * Represents a darts club affiliated with a federation.
 *
 * @property int $id
 * @property string $name
 * @property string|null $city
 * @property int|null $federation_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Federation|null $federation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 */
class Club extends Model
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
        'city',
        'federation_id',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the federation that owns the club.
     */
    public function federation(): BelongsTo
    {
        return $this->belongsTo(Federation::class);
    }

    /**
     * Get the players associated with this club.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}
