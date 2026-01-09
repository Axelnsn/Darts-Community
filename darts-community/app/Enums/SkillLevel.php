<?php

namespace App\Enums;

enum SkillLevel: string
{
    case DEBUTANT = 'debutant';
    case AMATEUR = 'amateur';
    case CONFIRME = 'confirme';
    case SEMI_PRO = 'semi-pro';
    case PRO = 'pro';

    /**
     * Get the French label for the skill level.
     */
    public function label(): string
    {
        return match ($this) {
            self::DEBUTANT => 'Débutant',
            self::AMATEUR => 'Amateur',
            self::CONFIRME => 'Confirmé',
            self::SEMI_PRO => 'Semi-pro',
            self::PRO => 'Pro',
        };
    }

    /**
     * Get the color class for the skill level badge.
     */
    public function color(): string
    {
        return match ($this) {
            self::DEBUTANT => 'gray',
            self::AMATEUR => 'green',
            self::CONFIRME => 'blue',
            self::SEMI_PRO => 'purple',
            self::PRO => 'yellow',
        };
    }
}
