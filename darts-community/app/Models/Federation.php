<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Federation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'country',
    ];

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
