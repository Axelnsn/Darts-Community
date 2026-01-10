<?php

namespace App\Models;

use App\Enums\SkillLevel;
use App\Enums\WalkonSongType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'club_id',
        'federation_id',
        'first_name',
        'last_name',
        'nickname',
        'date_of_birth',
        'city',
        'skill_level',
        'profile_photo_path',
        'cover_photo_path',
        'walkon_song_type',
        'walkon_song_url',
        'public_slug',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'skill_level' => SkillLevel::class,
            'walkon_song_type' => WalkonSongType::class,
        ];
    }

    /**
     * Get the user that owns the player.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the club that the player belongs to.
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the federation that the player belongs to.
     */
    public function federation(): BelongsTo
    {
        return $this->belongsTo(Federation::class);
    }

    /**
     * Get the list of fields used to calculate profile completeness.
     *
     * @return array<string>
     */
    public function getCompletableFields(): array
    {
        return [
            'first_name',
            'last_name',
            'nickname',
            'date_of_birth',
            'city',
            'skill_level',
            'profile_photo_path',
            'cover_photo_path',
        ];
    }

    /**
     * Calculate the profile completeness percentage.
     *
     * @return int Percentage from 0 to 100
     */
    public function getCompletenessPercentage(): int
    {
        $fields = $this->getCompletableFields();
        $filledCount = collect($fields)->filter(fn($field) => !empty($this->$field))->count();

        return round(($filledCount / count($fields)) * 100);
    }
}
