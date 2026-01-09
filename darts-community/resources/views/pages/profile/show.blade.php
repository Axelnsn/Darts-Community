<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mon Profil
            </h2>
            <a href="{{ route('player.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-dart-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-dart-green/90 focus:bg-dart-green/90 active:bg-dart-green/80 focus:outline-none focus:ring-2 focus:ring-dart-green focus:ring-offset-2 transition ease-in-out duration-150">
                Modifier
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <!-- Display Name -->
                        <div class="border-b border-gray-200 pb-4">
                            <div class="flex items-center gap-3">
                                <h3 class="text-2xl font-bold text-gray-900">
                                    @if($player->first_name || $player->last_name)
                                        {{ $player->first_name }} {{ $player->last_name }}
                                    @else
                                        <span class="text-gray-400 italic">Non renseigné</span>
                                    @endif
                                </h3>
                                @if($player->skill_level)
                                    <x-profile.skill-badge :level="$player->skill_level" />
                                @endif
                            </div>
                            @if($player->nickname)
                                <p class="text-lg text-dart-green font-medium">"{{ $player->nickname }}"</p>
                            @endif
                        </div>

                        <!-- Profile Details -->
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Prénom</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->first_name ?: 'Non renseigné' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->last_name ?: 'Non renseigné' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Pseudo</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->nickname ?: 'Non renseigné' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Date de naissance</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($player->date_of_birth)
                                        {{ $player->date_of_birth->format('d/m/Y') }}
                                    @else
                                        Non renseigné
                                    @endif
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Ville</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $player->city ?: 'Non renseigné' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->email }}
                                </dd>
                            </div>
                        </dl>

                        <!-- Profile Completeness Hint -->
                        @php
                            $filledFields = collect([
                                $player->first_name,
                                $player->last_name,
                                $player->nickname,
                                $player->date_of_birth,
                                $player->city,
                                $player->skill_level,
                            ])->filter()->count();
                            $totalFields = 6;
                            $percentage = round(($filledFields / $totalFields) * 100);
                        @endphp

                        @if($percentage < 100)
                            <div class="mt-6 bg-dart-gold/10 border border-dart-gold/30 rounded-lg p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-dart-gold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-dart-gold">Profil incomplet ({{ $percentage }}%)</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Complétez votre profil pour une meilleure expérience.
                                            <a href="{{ route('player.profile.edit') }}" class="font-medium text-dart-green hover:text-dart-green/80">Compléter mon profil</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>