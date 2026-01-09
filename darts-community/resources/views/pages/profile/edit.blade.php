<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mon Profil Joueur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Cover Photo Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Photo de couverture
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Ajoutez une photo de couverture à votre profil (format 3:1, max 5 Mo).
                            </p>
                        </header>

                        <div class="mt-6">
                            <!-- Cover Preview -->
                            <div class="relative w-full h-40 bg-gray-200 rounded-lg overflow-hidden">
                                @if($player->cover_photo_path)
                                    <img src="{{ asset('storage/' . $player->cover_photo_path) }}"
                                         alt="Photo de couverture"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 flex gap-4">
                                <!-- Upload Form -->
                                <form method="post" action="{{ route('player.profile.photo.store') }}" enctype="multipart/form-data" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="type" value="cover">
                                    <label class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        Choisir une image
                                        <input type="file" name="photo" class="hidden" accept="image/jpeg,image/png,image/webp" onchange="this.form.submit()">
                                    </label>
                                </form>

                                @if($player->cover_photo_path)
                                    <!-- Delete Form -->
                                    <form method="post" action="{{ route('player.profile.photo.destroy', ['type' => 'cover']) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <x-input-error class="mt-2" :messages="$errors->get('photo')" />

                            @if (session('status') === 'photo-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="mt-2 text-sm text-green-600">
                                    Photo mise à jour.
                                </p>
                            @endif
                            @if (session('status') === 'photo-deleted')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="mt-2 text-sm text-green-600">
                                    Photo supprimée.
                                </p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            <!-- Profile Photo Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Photo de profil
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Ajoutez une photo de profil (carrée, max 5 Mo).
                            </p>
                        </header>

                        <div class="mt-6 flex items-start gap-6">
                            <!-- Avatar Preview -->
                            <div class="relative w-32 h-32 bg-gray-200 rounded-full overflow-hidden flex-shrink-0">
                                @if($player->profile_photo_path)
                                    <img src="{{ asset('storage/' . $player->profile_photo_path) }}"
                                         alt="Photo de profil"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-4">
                                <!-- Upload Form -->
                                <form method="post" action="{{ route('player.profile.photo.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="profile">
                                    <label class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        Choisir une image
                                        <input type="file" name="photo" class="hidden" accept="image/jpeg,image/png,image/webp" onchange="this.form.submit()">
                                    </label>
                                </form>

                                @if($player->profile_photo_path)
                                    <!-- Delete Form -->
                                    <form method="post" action="{{ route('player.profile.photo.destroy', ['type' => 'profile']) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                @endif

                                <p class="text-sm text-gray-500">
                                    Formats acceptés : JPG, PNG, WebP
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Walk-on Song Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section x-data="{ songType: '{{ old('walkon_song_type', $player->walkon_song_type?->value ?? 'youtube') }}' }">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Walk-on Song
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Choisissez votre musique d'entrée comme les joueurs professionnels.
                            </p>
                        </header>

                        <div class="mt-6">
                            <!-- Tab Selection -->
                            <div class="flex space-x-4 mb-4">
                                <button type="button"
                                    @click="songType = 'youtube'"
                                    :class="songType === 'youtube' ? 'bg-dart-green text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    YouTube
                                </button>
                                <button type="button"
                                    @click="songType = 'spotify'"
                                    :class="songType === 'spotify' ? 'bg-dart-green text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Spotify
                                </button>
                                <button type="button"
                                    @click="songType = 'mp3'"
                                    :class="songType === 'mp3' ? 'bg-dart-green text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    MP3
                                </button>
                            </div>

                            <!-- Current Song Preview -->
                            @if($player->walkon_song_type)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-600 mb-2">Musique actuelle :</p>
                                    <x-profile.walkon-player :player="$player" />
                                </div>
                            @endif

                            <!-- YouTube Form -->
                            <form x-show="songType === 'youtube'" method="post" action="{{ route('player.profile.walkon.store') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="walkon_song_type" value="youtube">
                                <div>
                                    <x-input-label for="youtube_url" value="URL YouTube" />
                                    <x-text-input id="youtube_url" name="walkon_song_url" type="url" class="mt-1 block w-full"
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        :value="old('walkon_song_url', $player->walkon_song_type?->value === 'youtube' ? $player->walkon_song_url : '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('walkon_song_url')" />
                                    <p class="mt-1 text-sm text-gray-500">Ex: https://www.youtube.com/watch?v=dQw4w9WgXcQ</p>
                                </div>
                                <x-primary-button>Enregistrer</x-primary-button>
                            </form>

                            <!-- Spotify Form -->
                            <form x-show="songType === 'spotify'" method="post" action="{{ route('player.profile.walkon.store') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="walkon_song_type" value="spotify">
                                <div>
                                    <x-input-label for="spotify_url" value="URL Spotify" />
                                    <x-text-input id="spotify_url" name="walkon_song_url" type="url" class="mt-1 block w-full"
                                        placeholder="https://open.spotify.com/track/..."
                                        :value="old('walkon_song_url', $player->walkon_song_type?->value === 'spotify' ? $player->walkon_song_url : '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('walkon_song_url')" />
                                    <p class="mt-1 text-sm text-gray-500">Ex: https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT</p>
                                </div>
                                <x-primary-button>Enregistrer</x-primary-button>
                            </form>

                            <!-- MP3 Form -->
                            <form x-show="songType === 'mp3'" method="post" action="{{ route('player.profile.walkon.store') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <input type="hidden" name="walkon_song_type" value="mp3">
                                <div>
                                    <x-input-label for="walkon_file" value="Fichier MP3" />
                                    <input type="file" id="walkon_file" name="walkon_song_file" accept="audio/mpeg,audio/mp3"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-dart-green file:text-white hover:file:bg-dart-green/90 cursor-pointer" />
                                    <x-input-error class="mt-2" :messages="$errors->get('walkon_song_file')" />
                                    <p class="mt-1 text-sm text-gray-500">Max 10 Mo, durée max 2 minutes</p>
                                </div>
                                <x-primary-button>Enregistrer</x-primary-button>
                            </form>

                            <!-- Delete Button -->
                            @if($player->walkon_song_type)
                                <form method="post" action="{{ route('player.profile.walkon.destroy') }}" class="mt-4 pt-4 border-t border-gray-200">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer la musique
                                    </button>
                                </form>
                            @endif

                            @if (session('status') === 'walkon-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="mt-2 text-sm text-green-600">
                                    Musique mise à jour.
                                </p>
                            @endif
                            @if (session('status') === 'walkon-deleted')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="mt-2 text-sm text-green-600">
                                    Musique supprimée.
                                </p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            <!-- Profile Info Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Informations du profil
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Mettez à jour les informations de votre profil joueur.
                            </p>
                        </header>

                        <form method="post" action="{{ route('player.profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <x-input-label for="first_name" value="Prénom" />
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $player->first_name)" autofocus autocomplete="given-name" />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <div>
                                <x-input-label for="last_name" value="Nom" />
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $player->last_name)" autocomplete="family-name" />
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>

                            <div>
                                <x-input-label for="nickname" value="Pseudo" />
                                <x-text-input id="nickname" name="nickname" type="text" class="mt-1 block w-full" :value="old('nickname', $player->nickname)" />
                                <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
                                <p class="mt-1 text-sm text-gray-500">Optionnel - Votre pseudo de joueur</p>
                            </div>

                            <div>
                                <x-input-label for="date_of_birth" value="Date de naissance" />
                                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $player->date_of_birth?->format('Y-m-d'))" />
                                <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                            </div>

                            <div>
                                <x-input-label for="city" value="Ville" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $player->city)" autocomplete="address-level2" />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>

                            <div>
                                <x-input-label for="skill_level" value="Niveau de jeu" />
                                <select id="skill_level" name="skill_level" class="mt-1 block w-full border-gray-300 focus:border-dart-green focus:ring-dart-green rounded-md shadow-sm">
                                    <option value="">Sélectionnez votre niveau</option>
                                    @foreach(\App\Enums\SkillLevel::cases() as $level)
                                        <option value="{{ $level->value }}" @selected(old('skill_level', $player->skill_level?->value) === $level->value)>
                                            {{ $level->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('skill_level')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>Enregistrer</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >Profil mis à jour.</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
