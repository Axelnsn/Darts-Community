<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerProfileUpdateRequest;
use App\Services\PlayerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PlayerProfileController extends Controller
{
    public function __construct(
        protected PlayerService $playerService
    ) {}

    /**
     * Display the player's profile edit form.
     */
    public function edit(Request $request): View
    {
        $player = $this->playerService->createForUserIfNotExists($request->user());

        return view('pages.profile.edit', [
            'user' => $request->user(),
            'player' => $player,
        ]);
    }

    /**
     * Update the player's profile information.
     */
    public function update(PlayerProfileUpdateRequest $request): RedirectResponse
    {
        $player = $this->playerService->createForUserIfNotExists($request->user());
        $player->update($request->validated());

        return Redirect::route('player.profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Display the player's profile.
     */
    public function show(Request $request): View
    {
        $player = $this->playerService->createForUserIfNotExists($request->user());

        return view('pages.profile.show', [
            'user' => $request->user(),
            'player' => $player,
        ]);
    }
}
