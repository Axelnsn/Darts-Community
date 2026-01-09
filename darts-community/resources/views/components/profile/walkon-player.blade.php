@props(['player'])

@php
use App\Enums\WalkonSongType;
@endphp

@if($player->walkon_song_type && $player->walkon_song_url)
    <div {{ $attributes->merge(['class' => 'walkon-player']) }}>
        <h4 class="text-sm font-medium text-gray-500 mb-2">Walk-on Song</h4>

        @if($player->walkon_song_type === WalkonSongType::YouTube)
            @php
                // Extract video ID from YouTube URL - only alphanumeric, underscore, and hyphen allowed
                $videoId = null;
                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $player->walkon_song_url, $matches)) {
                    $videoId = $matches[1];
                }
            @endphp
            @if($videoId)
                <div class="aspect-video rounded-lg overflow-hidden">
                    <iframe
                        src="https://youtube.com/embed/{{ e($videoId) }}"
                        class="w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            @endif
        @elseif($player->walkon_song_type === WalkonSongType::Spotify)
            @php
                // Extract track ID from Spotify URL - Spotify IDs are 22 alphanumeric characters
                $trackId = null;
                if (preg_match('/open\.spotify\.com\/track\/([a-zA-Z0-9]{22})/', $player->walkon_song_url, $matches)) {
                    $trackId = $matches[1];
                }
            @endphp
            @if($trackId)
                <div class="rounded-lg overflow-hidden">
                    <iframe
                        src="https://open.spotify.com/embed/track/{{ e($trackId) }}"
                        class="w-full"
                        height="152"
                        frameborder="0"
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy">
                    </iframe>
                </div>
            @endif
        @elseif($player->walkon_song_type === WalkonSongType::Mp3)
            <div class="bg-gray-100 rounded-lg p-4">
                <audio controls class="w-full">
                    <source src="{{ asset('storage/' . $player->walkon_song_url) }}" type="audio/mpeg">
                    Votre navigateur ne supporte pas l'élément audio.
                </audio>
            </div>
        @endif
    </div>
@endif
