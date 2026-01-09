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
