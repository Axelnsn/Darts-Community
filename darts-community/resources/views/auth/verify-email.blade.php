<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Vérifiez votre email</h2>
        <p class="text-gray-600 mt-2">
            Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, nous vous en enverrons un autre avec plaisir.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="font-medium text-sm text-green-700">
                Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie lors de l'inscription.
            </p>
        </div>
    @endif

    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <x-primary-button class="w-full sm:w-auto">
                {{ __('Renvoyer l\'email de vérification') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-dart-green hover:text-dart-green-light transition-colors">
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>
