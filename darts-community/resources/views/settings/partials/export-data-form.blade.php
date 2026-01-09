<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Exporter mes données') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Téléchargez une copie de toutes vos données personnelles au format JSON (RGPD).') }}
        </p>
    </header>

    <div class="mt-6">
        <a href="{{ route('settings.export') }}" class="inline-flex items-center px-4 py-2 bg-dart-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-dart-green-light focus:bg-dart-green-light active:bg-dart-green focus:outline-none focus:ring-2 focus:ring-dart-gold focus:ring-offset-2 transition ease-in-out duration-150">
            {{ __('Exporter mes données') }}
        </a>
    </div>
</section>
