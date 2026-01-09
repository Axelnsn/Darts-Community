<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Modifier l\'adresse email') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Mettez à jour votre adresse email. Une vérification sera envoyée à la nouvelle adresse.') }}
        </p>
    </header>

    <form method="post" action="{{ route('settings.email.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_email" :value="__('Email actuel')" />
            <x-text-input id="current_email" type="email" class="mt-1 block w-full bg-gray-100" :value="old('current_email', $user->email)" disabled />
        </div>

        <div>
            <x-input-label for="email" :value="__('Nouvelle adresse email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="current_password_email" :value="__('Mot de passe actuel')" />
            <x-text-input id="current_password_email" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'email-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Email mis à jour avec succès.') }}</p>
            @endif
        </div>
    </form>
</section>
