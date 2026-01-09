<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Darts Community')</title>
    <meta name="description" content="@yield('description', 'Créez votre profil de joueur de fléchettes comme les pros. Gérez votre équipement et connectez avec votre club.')">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dart-green': '#1B4D3E',
                        'dart-green-light': '#2D7A5C',
                        'dart-gold': '#D4AF37',
                        'dart-red': '#C41E3A',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Inter Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    @yield('content')

    @stack('scripts')
</body>
</html>
