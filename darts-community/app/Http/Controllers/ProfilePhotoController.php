<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoUploadRequest;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfilePhotoController extends Controller
{
    public function __construct(
        protected UploadService $uploadService
    ) {}

    /**
     * Store a newly uploaded photo.
     */
    public function store(PhotoUploadRequest $request): RedirectResponse
    {
        $player = $request->user()->player;
        $type = $request->validated('type');
        $file = $request->validated('photo');

        if ($type === 'profile') {
            $this->uploadService->uploadProfilePhoto($player, $file);
        } else {
            $this->uploadService->uploadCoverPhoto($player, $file);
        }

        return redirect()->route('player.profile.edit')
            ->with('status', 'photo-updated');
    }

    /**
     * Remove the specified photo.
     */
    public function destroy(Request $request, string $type): RedirectResponse
    {
        // Validate type parameter
        if (!in_array($type, ['profile', 'cover'], true)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $player = $request->user()->player;

        if ($type === 'profile') {
            $this->uploadService->deleteProfilePhoto($player);
        } else {
            $this->uploadService->deleteCoverPhoto($player);
        }

        return redirect()->route('player.profile.edit')
            ->with('status', 'photo-deleted');
    }
}
