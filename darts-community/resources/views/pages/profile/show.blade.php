{{-- TODO: i18n - Extract all hardcoded French strings to lang files for future internationalization --}}
<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cover Photo Banner -->
            <div class="profile-cover-banner relative w-full h-48 sm:h-64 rounded-t-lg overflow-hidden">
                @if($player->cover_photo_path)
                    <img src="{{ asset('storage/' . $player->cover_photo_path) }}"
                         alt="Photo de couverture"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-dart-green to-dart-green-light flex items-center justify-center">
                        <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif

                <!-- Edit Button -->
                <div class="absolute top-4 right-4">
                    <a href="{{ route('player.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white/90 hover:bg-white border border-transparent rounded-md font-semibold text-xs text-dart-green uppercase tracking-widest shadow-sm transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                </div>
            </div>

            <!-- Profile Info Section -->
            <div class="bg-white shadow-sm rounded-b-lg">
                <!-- Avatar & Name Section -->
                <div class="px-6 sm:px-8 pb-6">
                    <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                        <!-- Avatar (pulled up into cover) -->
                        <div class="profile-avatar-overlay -mt-16 sm:-mt-20 flex-shrink-0">
                            <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full border-4 border-white bg-gray-200 overflow-hidden shadow-lg">
                                @if($player->profile_photo_path)
                                    <img src="{{ asset('storage/' . $player->profile_photo_path) }}"
                                         alt="Photo de profil"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-white">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Name, Nickname & Skill Badge -->
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pt-2 sm:pt-4">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                                    @if($player->first_name || $player->last_name)
                                        {{ $player->first_name }} {{ $player->last_name }}
                                    @else
                                        <span class="text-gray-400 italic">Nom non renseigné</span>
                                    @endif
                                </h1>
                                @if($player->nickname)
                                    <p class="text-lg text-dart-green font-medium">"{{ $player->nickname }}"</p>
                                @endif
                                <p class="text-gray-500 flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-label="Localisation" role="img">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $player->city ?: 'Ville non renseignée' }}
                                </p>
                            </div>
                            @if($player->skill_level)
                                <x-profile.skill-badge :level="$player->skill_level" class="self-start sm:self-center" />
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Cards Grid -->
                <div class="px-6 sm:px-8 pb-8 space-y-6">
                    <!-- Personal Info Card -->
                    <div class="profile-card bg-gray-50 rounded-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-dart-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-label="Informations personnelles" role="img">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informations personnelles
                        </h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Prénom</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->first_name ?: 'Non renseigné' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->last_name ?: 'Non renseigné' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pseudo</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->nickname ?: 'Non renseigné' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de naissance</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($player->date_of_birth)
                                        {{ $player->date_of_birth->format('d/m/Y') }}
                                    @else
                                        Non renseigné
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ville</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->city ?: 'Non renseigné' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->email }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Walk-on Song Card -->
                    @if($player->walkon_song_type && $player->walkon_song_url)
                        <div class="profile-card bg-gray-50 rounded-lg p-6 border border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-dart-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-label="Walk-on Song" role="img">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                Walk-on Song
                            </h3>
                            <x-profile.walkon-player :player="$player" />
                        </div>
                    @endif

                    <!-- Affiliation Card -->
                    <div class="profile-card bg-gray-50 rounded-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-dart-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-label="Affiliation" role="img">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Affiliation
                        </h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Club</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($player->club)
                                        <a href="#" class="text-dart-green hover:underline">
                                            {{ $player->club->name }}
                                        </a>
                                        @if($player->club->city)
                                            <span class="text-gray-500"> - {{ $player->club->city }}</span>
                                        @endif
                                    @else
                                        Sans club
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Profile Completeness Hint -->
                    @php
                        $percentage = $player->getCompletenessPercentage();
                    @endphp

                    @if($percentage < 100)
                        <div class="profile-card bg-dart-gold/10 border border-dart-gold/30 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-dart-gold flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-label="Information" role="img">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                </svg>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-dart-gold">Profil incomplet ({{ $percentage }}%)</h3>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-dart-gold h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">
                                        Complétez votre profil pour une meilleure expérience.
                                        <a href="{{ route('player.profile.edit') }}" class="font-medium text-dart-green hover:text-dart-green/80">Compléter mon profil →</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
