<?php

namespace App\Http\Controllers;

use App\Enums\WalkonSongType;
use App\Http\Requests\WalkonSongRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WalkonSongController extends Controller
{
    /**
     * Store or update the walk-on song.
     */
    public function store(WalkonSongRequest $request): RedirectResponse
    {
        $player = $request->user()->player;

        if (!$player) {
            abort(404, 'Player profile not found.');
        }

        $type = WalkonSongType::from($request->validated('walkon_song_type'));

        // Delete old MP3 file if switching from MP3 to another type
        if ($player->walkon_song_type === WalkonSongType::Mp3 && $player->walkon_song_url) {
            $this->deleteFile($player->walkon_song_url);
        }

        if ($type === WalkonSongType::Mp3) {
            // Handle MP3 file upload
            $file = $request->validated('walkon_song_file');
            $path = $file->store('walkon', 'public');

            $player->update([
                'walkon_song_type' => $type,
                'walkon_song_url' => $path,
            ]);
        } else {
            // Handle YouTube or Spotify URL
            $player->update([
                'walkon_song_type' => $type,
                'walkon_song_url' => trim($request->validated('walkon_song_url')),
            ]);
        }

        return redirect()->route('player.profile.edit')
            ->with('status', 'walkon-updated');
    }

    /**
     * Remove the walk-on song.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $player = $request->user()->player;

        if (!$player) {
            abort(404, 'Player profile not found.');
        }

        // Delete MP3 file if exists
        if ($player->walkon_song_type === WalkonSongType::Mp3 && $player->walkon_song_url) {
            $this->deleteFile($player->walkon_song_url);
        }

        $player->update([
            'walkon_song_type' => null,
            'walkon_song_url' => null,
        ]);

        return redirect()->route('player.profile.edit')
            ->with('status', 'walkon-deleted');
    }

    /**
     * Delete a file from storage.
     */
    protected function deleteFile(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
