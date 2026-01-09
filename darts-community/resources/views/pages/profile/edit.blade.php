<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mon Profil Joueur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
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
