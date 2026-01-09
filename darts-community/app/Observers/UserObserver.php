<?php

namespace App\Observers;

use App\Models\User;
use App\Services\PlayerService;

class UserObserver
{
    public function __construct(
        protected PlayerService $playerService
    ) {}

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->playerService->createForUser($user);
    }
}
