<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gdpr_consent_at',
        'gdpr_deletion_requested_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gdpr_consent_at' => 'datetime',
            'gdpr_deletion_requested_at' => 'datetime',
        ];
    }

    /**
     * Check if the user's grace period has expired (30 days).
     */
    public function gracePeriodExpired(): bool
    {
        if (!$this->gdpr_deletion_requested_at) {
            return false;
        }

        return $this->gdpr_deletion_requested_at->addDays(30)->isPast();
    }

    /**
     * Get the player profile associated with the user.
     */
    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
    }
}
