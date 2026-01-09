@extends('layouts.public')

@section('title', 'Darts Community - Votre identité de joueur comme les pros')
@section('description', 'Créez votre profil de joueur de fléchettes professionnel. Gérez votre équipement, personnalisez votre identité et connectez avec votre club.')

@section('content')
    <!-- Navigation Bar -->
    <nav class="absolute top-0 left-0 right-0 z-20 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-dart-gold rounded-full flex items-center justify-center">
                        <span class="text-xl">🎯</span>
                    </div>
                    <span class="text-xl font-bold text-white">Darts Community</span>
                </a>

                <!-- Auth Links -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="text-white/80 hover:text-white transition-colors text-sm font-medium">
                            Mon profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white/80 hover:text-white transition-colors text-sm font-medium">
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white/80 hover:text-white transition-colors text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-dart-gold text-dart-green rounded-lg hover:bg-yellow-400 transition-colors text-sm font-semibold">
                            S'inscrire
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-dart-green via-dart-green to-dart-green-light overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full border-[40px] border-white"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full border-[30px] border-white"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] rounded-full border-[20px] border-white"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[50px] h-[50px] rounded-full bg-dart-red"></div>
        </div>

        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                Votre identité de joueur<br>
                <span class="text-dart-gold">comme les pros</span>
            </h1>

            <p class="text-lg sm:text-xl text-gray-200 mb-10 max-w-2xl mx-auto">
                Créez votre profil de joueur de fléchettes, gérez votre équipement et connectez avec votre club.
                Rejoignez la communauté des passionnés de darts.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-dart-green bg-dart-gold rounded-lg hover:bg-yellow-400 transition-colors duration-200 min-w-[200px] min-h-[56px]">
                    Créer mon profil
                </a>
                <a href="#features" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white rounded-lg hover:bg-white/10 transition-colors duration-200 min-w-[200px] min-h-[56px]">
                    Découvrir
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Feature Cards Section -->
    <section id="features" class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    Tout pour le joueur de fléchettes
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Une plateforme complète pour gérer votre identité de joueur et votre équipement.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <!-- Feature Card 1: Profil Joueur -->
                <div class="bg-gray-50 rounded-2xl p-6 sm:p-8 text-center hover:shadow-lg transition-shadow duration-200">
                    <div class="w-16 h-16 bg-dart-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl" role="img" aria-label="Profil">👤</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Profil Joueur</h3>
                    <p class="text-gray-600">
                        Créez votre identité de joueur avec votre photo, votre walk-on song et vos statistiques personnelles.
                    </p>
                </div>

                <!-- Feature Card 2: Mon Setup -->
                <div class="bg-gray-50 rounded-2xl p-6 sm:p-8 text-center hover:shadow-lg transition-shadow duration-200">
                    <div class="w-16 h-16 bg-dart-gold/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl" role="img" aria-label="Fléchettes">🎯</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Mon Setup</h3>
                    <p class="text-gray-600">
                        Gérez votre équipement : fûts, tiges, ailettes et pointes. Assemblez vos fléchettes parfaites.
                    </p>
                </div>

                <!-- Feature Card 3: Communauté -->
                <div class="bg-gray-50 rounded-2xl p-6 sm:p-8 text-center hover:shadow-lg transition-shadow duration-200">
                    <div class="w-16 h-16 bg-dart-red/10 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl" role="img" aria-label="Communauté">🏛️</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Communauté</h3>
                    <p class="text-gray-600">
                        Connectez avec votre club, découvrez d'autres joueurs et partagez votre passion.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dart-green text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-center sm:text-left">
                    <p class="font-semibold text-lg">Darts Community</p>
                    <p class="text-gray-300 text-sm">&copy; {{ date('Y') }} Tous droits réservés</p>
                </div>
                <nav class="flex gap-6">
                    <a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">À propos</a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Contact</a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Mentions légales</a>
                </nav>
            </div>
        </div>
    </footer>
@endsection
