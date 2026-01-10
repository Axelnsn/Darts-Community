<?php

namespace App\Observers;

use App\Models\Federation;
use InvalidArgumentException;

class FederationObserver
{
    /**
     * Handle the Federation "creating" event.
     */
    public function creating(Federation $federation): void
    {
        $this->validateCode($federation);
    }

    /**
     * Handle the Federation "updating" event.
     */
    public function updating(Federation $federation): void
    {
        if ($federation->isDirty('code')) {
            $this->validateCode($federation);
        }
    }

    /**
     * Validate federation code format (3 uppercase letters).
     *
     * @throws InvalidArgumentException
     */
    private function validateCode(Federation $federation): void
    {
        if (!preg_match('/^[A-Z]{3}$/', $federation->code)) {
            throw new InvalidArgumentException(
                "Federation code must be exactly 3 uppercase letters (e.g., 'FFD'). Got: '{$federation->code}'"
            );
        }
    }
}
