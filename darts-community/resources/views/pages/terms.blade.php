@extends('layouts.public')

@section('title', __('Conditions d\'utilisation'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-dart-green px-6 py-4">
                <h1 class="text-2xl font-bold text-white">{{ __('Conditions d\'utilisation') }}</h1>
            </div>

            <div class="px-6 py-8 prose prose-lg max-w-none">
                <p class="text-gray-600 text-sm italic mb-8">
                    Dernière mise à jour : {{ now()->format('d/m/Y') }}
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">1. Acceptation des conditions</h2>
                <p class="text-gray-700 mb-4">
                    En utilisant Darts Community, vous acceptez les présentes conditions d'utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser ce service.
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">2. Description du service</h2>
                <p class="text-gray-700 mb-4">
                    Darts Community est une plateforme communautaire dédiée aux passionnés de fléchettes. Elle permet de :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-4 ml-4">
                    <li>Créer et gérer un profil de joueur</li>
                    <li>Répertorier votre équipement</li>
                    <li>Rejoindre et découvrir des clubs</li>
                    <li>Partager vos performances</li>
                </ul>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">3. Inscription et compte</h2>
                <p class="text-gray-700 mb-4">
                    Pour utiliser certaines fonctionnalités, vous devez créer un compte. Vous êtes responsable de :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-4 ml-4">
                    <li>Fournir des informations exactes</li>
                    <li>Maintenir la confidentialité de votre mot de passe</li>
                    <li>Toutes les activités effectuées sous votre compte</li>
                </ul>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">4. Règles de conduite</h2>
                <p class="text-gray-700 mb-4">
                    En utilisant nos services, vous vous engagez à :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-4 ml-4">
                    <li>Respecter les autres utilisateurs</li>
                    <li>Ne pas publier de contenu illégal ou offensant</li>
                    <li>Ne pas usurper l'identité d'autres personnes</li>
                    <li>Ne pas tenter de compromettre la sécurité du service</li>
                </ul>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">5. Propriété intellectuelle</h2>
                <p class="text-gray-700 mb-4">
                    Le contenu de Darts Community (logos, textes, images) est protégé par le droit d'auteur. Toute reproduction non autorisée est interdite.
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">6. Limitation de responsabilité</h2>
                <p class="text-gray-700 mb-4">
                    Darts Community est fourni "tel quel". Nous ne garantissons pas la disponibilité continue du service et ne pouvons être tenus responsables des dommages indirects.
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">7. Modifications</h2>
                <p class="text-gray-700 mb-4">
                    Nous nous réservons le droit de modifier ces conditions à tout moment. Les modifications seront notifiées par email ou sur le site.
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">8. Contact</h2>
                <p class="text-gray-700 mb-4">
                    Pour toute question concernant ces conditions, contactez-nous à : contact@darts-community.fr
                </p>

                <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                    <p class="text-gray-600 text-sm">
                        <strong>Note :</strong> Cette page est un placeholder. Le contenu juridique complet sera ajouté ultérieurement.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-dart-green hover:text-dart-green-light transition-colors">
                &larr; {{ __('Retour à l\'accueil') }}
            </a>
        </div>
    </div>
</div>
@endsection
