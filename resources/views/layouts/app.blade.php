<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CandidatureTracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            
            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                🎯 CandidatureTracker
            </a>

            {{-- Nav Links --}}
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    <a href="{{ route('dashboard') }}" 
                       class="text-gray-700 hover:text-blue-600">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Déconnexion
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-blue-600">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Inscription
                    </a>
                @endguest
            </div>

        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="max-w-7xl mx-auto px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4">
        @yield('content')
    </main>

</body>
</html>