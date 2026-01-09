<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Créer un compte</h2>
        <p class="text-gray-600 mt-1">Rejoignez la communauté des joueurs de fléchettes</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
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
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimum 8 caractères" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500">Le mot de passe doit contenir au moins 8 caractères.</p>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Répétez le mot de passe" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- GDPR Consent -->
        <div class="mt-4">
            <label for="gdpr_consent" class="flex items-start gap-2">
                <input type="checkbox" id="gdpr_consent" name="gdpr_consent" value="1" class="rounded border-gray-300 text-dart-green shadow-sm focus:ring-dart-green mt-1" {{ old('gdpr_consent') ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">
                    {!! __("J'accepte la <a href=\":privacy_url\" class=\"text-dart-green hover:text-dart-green-light underline\" target=\"_blank\">politique de confidentialité</a> et les <a href=\":terms_url\" class=\"text-dart-green hover:text-dart-green-light underline\" target=\"_blank\">conditions d'utilisation</a>.", [
                        'privacy_url' => route('privacy-policy'),
                        'terms_url' => route('terms'),
                    ]) !!}
                </span>
            </label>
            <x-input-error :messages="$errors->get('gdpr_consent')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __("S'inscrire") }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="font-medium text-dart-green hover:text-dart-green-light transition-colors">
                    Se connecter
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
