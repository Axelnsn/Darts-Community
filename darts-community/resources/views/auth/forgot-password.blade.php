<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Mot de passe oublié ?</h2>
        <p class="text-gray-600 mt-2">
            Pas de problème. Indiquez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Envoyer le lien de réinitialisation') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-dart-green hover:text-dart-green-light transition-colors">
                ← Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
