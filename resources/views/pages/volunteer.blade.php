@extends('layouts.app')

@section('title', 'Je veux aider')

@section('content')
    <section class="volunteer-page mx-auto max-w-3xl py-6 sm:py-10">
        <div class="volunteer-hero">
            <p>Je veux aider</p>
            <h1>Bénévolat & dons</h1>
            <span class="volunteer-hero-icon" aria-hidden="true">🤝</span>
        </div>

        @if (session('status'))
            <p class="volunteer-status">{{ session('status') }}</p>
        @endif

        <div class="volunteer-donations">
            <article class="volunteer-donation-card">
                <span class="volunteer-donation-icon" aria-hidden="true">○</span>
                <h2>Don financier</h2>
                <p>Particuliers, entreprises ou associations.</p>
                <a href="{{ route('donation.create', ['type' => 'financial']) }}">Donner →</a>
            </article>
            <article class="volunteer-donation-card volunteer-donation-card-food">
                <span class="volunteer-donation-icon" aria-hidden="true">○</span>
                <h2>Don alimentaire</h2>
                <p>Dépose des denrées, seul ou avec ton organisation.</p>
                <a href="{{ route('donation.create', ['type' => 'food']) }}">Proposer un don →</a>
            </article>
        </div>

        <div class="volunteer-section-heading">
            <h2>Créneaux bénévoles</h2>
        </div>

        <div class="volunteer-opportunities">
            @foreach ($opportunities as $opportunity)
                <article class="volunteer-opportunity">
                    <div>
                        <h3>{{ $opportunity['title'] }}</h3>
                        <p>🤝 {{ $opportunity['partner'] }}</p>
                        <small>→ {{ $opportunity['display_date'] }} · {{ $opportunity['time'] }}</small>
                    </div>
                    @auth
                        <form method="POST" action="{{ route('volunteer.join') }}">
                            @csrf
                            <input type="hidden" name="opportunity" value="{{ $opportunity['key'] }}">
                            <button type="submit">S'inscrire</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">S'inscrire</a>
                    @endauth
                </article>
            @endforeach
        </div>

        @if ($associationEvents->isNotEmpty())
            <div id="association-events" class="volunteer-section-heading"><h2>Événements des associations</h2></div>
            <div class="volunteer-opportunities">
                @foreach ($associationEvents as $event)
                    <article class="volunteer-opportunity">
                        <div>
                            <h3>{{ $event->title }}</h3>
                            <p>🤝 {{ $event->user->organization ?? 'Association partenaire' }} · {{ $event->location }}</p>
                            <small>→ {{ $event->starts_at->format('d/m/Y') }} · {{ $event->starts_at->format('H\hi') }}</small>
                        </div>
                        @auth
                            <form method="POST" action="{{ route('volunteer.event.join') }}">
                                @csrf
                                <input type="hidden" name="event" value="{{ $event->id }}">
                                <button type="submit">S'inscrire</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}">S'inscrire</a>
                        @endauth
                    </article>
                @endforeach
            </div>
        @endif

        <article id="partenaire" class="volunteer-partner-card">
            <h2>🏪 Vous êtes un commerce ?</h2>
            <p>Proposez des dons ou accueillez une collecte dans votre magasin.</p>
            <a href="{{ route('register.professional') }}">Devenir partenaire →</a>
        </article>
    </section>
@endsection
