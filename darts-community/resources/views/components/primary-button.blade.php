<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center w-full px-4 py-3 bg-dart-green border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-dart-green-light focus:bg-dart-green-light active:bg-dart-green focus:outline-none focus:ring-2 focus:ring-dart-green focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
