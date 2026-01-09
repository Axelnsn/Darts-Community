@extends('layouts.public')

@section('title', __('Politique de confidentialité'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-dart-green px-6 py-4">
                <h1 class="text-2xl font-bold text-white">{{ __('Politique de confidentialité') }}</h1>
            </div>

            <div class="px-6 py-8 prose prose-lg max-w-none">
                <p class="text-gray-600 text-sm italic mb-8">
                    Dernière mise à jour : {{ now()->format('d/m/Y') }}
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">1. Introduction</h2>
                <p class="text-gray-700 mb-4">
                    Bienvenue sur Darts Community. Cette politique de confidentialité explique comment nous collectons, utilisons, stockons et protégeons vos données personnelles conformément au Règlement Général sur la Protection des Données (RGPD).
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">2. Données collectées</h2>
                <p class="text-gray-700 mb-4">
                    Nous collectons les données suivantes :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-4 ml-4">
                    <li>Adresse email (pour la création de compte et la connexion)</li>
                    <li>Informations de profil (si vous choisissez de les fournir)</li>
                    <li>Données d'équipement et préférences de jeu</li>
                </ul>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">3. Utilisation des données</h2>
                <p class="text-gray-700 mb-4">
                    Vos données sont utilisées pour :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-4 ml-4">
                    <li>Gérer votre compte utilisateur</li>
                    <li>Personnaliser votre expérience sur la plateforme</li>
                    <li>Vous envoyer des communications importantes</li>
                </ul>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">4. Vos droits RGPD</h2>
                <p class="text-gray-700 mb-4">
                    Conformément au RGPD, vous disposez des droits suivants :
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-4 ml-4">
                    <li><strong>Droit d'accès :</strong> Vous pouvez demander une copie de vos données</li>
                    <li><strong>Droit de rectification :</strong> Vous pouvez modifier vos informations</li>
                    <li><strong>Droit à l'effacement :</strong> Vous pouvez supprimer votre compte</li>
                    <li><strong>Droit à la portabilité :</strong> Vous pouvez exporter vos données</li>
                </ul>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">5. Conservation des données</h2>
                <p class="text-gray-700 mb-4">
                    Vos données sont conservées tant que votre compte est actif. En cas de suppression de compte, vos données sont conservées pendant 30 jours (période de grâce) avant suppression définitive.
                </p>

                <h2 class="text-xl font-semibold text-dart-green mt-6 mb-4">6. Contact</h2>
                <p class="text-gray-700 mb-4">
                    Pour toute question concernant cette politique ou vos données personnelles, contactez-nous à : contact@darts-community.fr
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