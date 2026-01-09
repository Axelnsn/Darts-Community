<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Supprimer mon compte') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre compte supprimé, toutes vos données seront définitivement effacées après une période de grâce de 30 jours.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-account-deletion')"
    >{{ __('Supprimer mon compte') }}</x-danger-button>

    <x-modal name="confirm-account-deletion" :show="$errors->accountDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('settings.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Cette action est irréversible. Vos données seront conservées pendant 30 jours avant suppression définitive. Tapez SUPPRIMER pour confirmer.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="confirmation" :value="__('Confirmation')" class="sr-only" />

                <x-text-input
                    id="confirmation"
                    name="confirmation"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Tapez SUPPRIMER pour confirmer') }}"
                />

                <x-input-error :messages="$errors->accountDeletion->get('confirmation')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="password_delete" :value="__('Mot de passe')" class="sr-only" />

                <x-text-input
                    id="password_delete"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Mot de passe') }}"
                />

                <x-input-error :messages="$errors->accountDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Supprimer mon compte') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
