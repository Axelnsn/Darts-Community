<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Darts Community') }} - @yield('title', 'Authentification')</title>

    <!-- Inter Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-dart-green to-dart-green-light flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Background Pattern (Dartboard rings) -->
        <div class="absolute inset-0 opacity-5 pointer-events-none overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full border-[60px] border-white"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full border-[40px] border-white"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full border-[30px] border-white"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] rounded-full border-[20px] border-white"></div>
        </div>

        <!-- Logo -->
        <div class="relative z-10 mb-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-dart-gold rounded-full flex items-center justify-center">
                    <span class="text-2xl">🎯</span>
                </div>
                <span class="text-2xl font-bold text-white">Darts Community</span>
            </a>
        </div>

        <!-- Card Container -->
        <div class="relative z-10 w-full sm:max-w-md mx-4 px-6 py-8 bg-white shadow-2xl rounded-xl">
            {{ $slot }}
        </div>

        <!-- Footer Link -->
        <div class="relative z-10 mt-6">
            <a href="{{ route('home') }}" class="text-white/80 hover:text-white text-sm transition-colors">
                ← Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
