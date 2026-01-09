<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Connexion</h2>
        <p class="text-gray-600 mt-1">Accédez à votre espace joueur</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Votre mot de passe" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-dart-green shadow-sm focus:ring-dart-green" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-dart-green hover:text-dart-green-light transition-colors" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-medium text-dart-green hover:text-dart-green-light transition-colors">
                    Créer un compte
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
