<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Abri-co') | Abri-co</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen">
    @unless (request()->routeIs('home') || trim($__env->yieldContent('minimal_layout')) === 'true')
        <header class="border-b border-slate-200/80 bg-[#f7f5ef]/90 backdrop-blur">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-10" aria-label="Navigation principale">
                <a href="{{ route('home') }}" class="brand-logo" aria-label="Abri-co">
                    <img data-brand-logo src="{{ asset('image/logo-abroo-co.svg') }}" alt="Abri-co" class="brand-logo-image">
                </a>
                <div class="hidden items-center gap-7 text-sm font-medium text-slate-600 md:flex">
                    <a href="{{ route('help') }}" class="transition hover:text-coral">Besoin d'aide</a>
                    <a href="{{ route('volunteer') }}" class="transition hover:text-coral">Je veux aider</a>
                    @auth
                        @if (auth()->user()->account_type === 'professional')
                            <a href="{{ route('association') }}" class="transition hover:text-coral">Associations</a>
                        @endif
                    @endauth
                </div>
                @auth
                    <a href="{{ route('profile') }}" class="rounded-full bg-coral px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-coral-dark">Mon profil</a>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="rounded-full px-3 py-2 text-sm font-bold text-ink transition hover:text-coral">Se connecter</a>
                        <a href="{{ route('register.beneficiary') }}" class="rounded-full bg-coral px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-coral-dark">Inscription</a>
                    </div>
                @endauth
            </nav>
        </header>
    @endunless

    <main class="{{ trim($__env->yieldContent('minimal_layout')) === 'true' ? '' : 'mx-auto max-w-7xl px-6 lg:px-10' }}">
        @yield('content')
    </main>

    @unless (trim($__env->yieldContent('minimal_layout')) === 'true')
        <footer class="mt-10 border-t border-slate-200 px-6 py-8 text-center text-sm text-slate-500 lg:px-10">
            <p>Abri-co, créer du lien quand il compte vraiment.</p>
        </footer>
    @endunless
</body>
</html>
