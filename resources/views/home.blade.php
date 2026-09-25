@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    {{-- L'accueil sert de point de départ vers les parcours aide, bénévolat et association. --}}
    <nav class="mx-auto flex max-w-3xl items-center justify-between border-b border-[#eaded6] py-5" aria-label="Navigation principale">
        <a href="{{ route('home') }}" class="brand-logo" aria-label="Abri-co">
            <img data-brand-logo src="{{ Vite::asset('resources/image/logo-abro-co.svg') }}" alt="Abri-co" class="brand-logo-image">
        </a>
        @auth
            <a href="{{ route('profile') }}" class="rounded-full bg-coral px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-coral-dark">Mon profil</a>
        @else
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="rounded-full px-3 py-2 text-sm font-bold text-ink transition hover:text-coral">Se connecter</a>
                <a href="{{ route('register.beneficiary') }}" class="rounded-full bg-coral px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-coral-dark">Inscription</a>
            </div>
        @endauth
    </nav>

    <section class="mx-auto max-w-3xl py-8 sm:py-14">
        <div class="mb-8">
            <p class="brand-logo mascot-text-trigger text-3xl tracking-tight text-ink sm:text-5xl" data-mascot-trigger tabindex="0" role="button">Abri<span class="text-coral">'co</span></p>
            <p class="mt-3 max-w-xs text-sm leading-5 text-[#b46e5b] sm:text-base">Donner à ceux qui en ont besoin,<br>trouver de l'aide quand on en a besoin.</p>
        </div>

        <div class="grid gap-3 sm:grid-cols-3 sm:gap-5">
            <a href="{{ route('help') }}" class="home-action home-action-help group">
                <span class="home-action-icon" aria-hidden="true">🧑‍💼</span>
                <span class="home-action-copy"><strong>J'ai besoin d'aide</strong><small>Collectes, épiceries, aides CAF & CROUS</small></span>
                <span class="home-action-arrow" aria-hidden="true">→</span>
            </a>
            <a href="{{ route('volunteer') }}" class="home-action home-action-volunteer group">
                <span class="home-action-icon" aria-hidden="true">🤝</span>
                <span class="home-action-copy"><strong>Je veux aider</strong><small>Bénévolat, dons, besoins en temps réel</small></span>
                <span class="home-action-arrow" aria-hidden="true">→</span>
            </a>
            <a href="{{ route('association') }}" class="home-action home-action-association group">
                <span class="home-action-icon" aria-hidden="true">🏛️</span>
                <span class="home-action-copy"><strong>Je suis une asso</strong><small>Référencer, gérer les besoins</small></span>
                <span class="home-action-arrow" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="mt-9 sm:mt-14">
            <h2 class="text-sm font-bold text-ink">Partage en chiffres</h2>
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                <div class="home-stat"><strong>0</strong><span>Étudiants aidés</span></div>
                <div class="home-stat"><strong>0</strong><span>Collectes actives</span></div>
                <div class="home-stat"><strong>0</strong><span>Bénévoles inscrits</span></div>
                <div class="home-stat"><strong>{{ $partnerAssociations->count() }}</strong><span>Assos partenaires</span></div>
            </div>
        </div>

        <section class="home-partners" aria-labelledby="home-partners-title">
            <h2 id="home-partners-title">Associations partenaires</h2>
            <div class="home-partner-list">
                @forelse ($partnerAssociations as $association)
                    <article class="home-partner-card">
                        <span aria-hidden="true">🏛️</span>
                        <div>
                            <h3>{{ $association->organization }}</h3>
                            <p>{{ $association->city ?: 'Partenaire Abri-co' }}</p>
                        </div>
                    </article>
                @empty
                    <p class="home-partners-empty">Les associations partenaires apparaîtront ici.</p>
                @endforelse
            </div>
        </section>
    </section>
