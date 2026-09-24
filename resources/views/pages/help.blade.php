@extends('layouts.app')

@section('title', "J'ai besoin d'aide")

@section('content')
    <section class="help-page mx-auto max-w-3xl py-6 sm:py-10">
        <div class="help-hero">
            <p>J'ai besoin d'aide</p>
            <h1>Collectes & aides</h1>
            <div class="help-tabs" aria-label="Catégories d'aide">
                <button type="button" class="help-tab is-active" data-help-filter="all" aria-pressed="true">Tout</button>
                <button type="button" class="help-tab" data-help-filter="collectes" aria-pressed="false">Collectes</button>
                <button type="button" class="help-tab" data-help-filter="anti-gaspi" aria-pressed="false">Anti-gaspi</button>
                <button type="button" class="help-tab" data-help-filter="aides" aria-pressed="false">Aides</button>
                <button type="button" class="help-tab" data-help-filter="petit-budget" aria-pressed="false">Petit budget</button>
            </div>
            <label class="help-sort"><span>Trier les publications</span><select data-help-sort><option value="date">Plus proche</option><option value="priority">Plus urgent</option><option value="category">Par catégorie</option></select></label>
        </div>

        @if (session('status'))
            <p class="help-status">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="help-errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="help-search" role="search">
            <label class="sr-only" for="help-search">Rechercher une ville ou un service</label>
            <input id="help-search" type="search" placeholder="Rechercher une ville ou un service...">
        </div>

        @guest
            <div class="help-access-note">
                <strong>Documentation rapide</strong>
                <p>Consultez les aides disponibles. Connectez-vous pour voir les créneaux et réserver.</p>
                <a href="{{ route('login') }}">Se connecter pour réserver →</a>
            </div>
        @endguest

        @if ($associationEvents->isNotEmpty())
            <div class="help-feed-heading"><h2>Actualités des associations</h2></div>
            <div class="help-list">
                @foreach ($associationEvents as $event)
                    <article class="help-service-card association-feed-card" data-help-category="{{ $event->category }}" data-help-text="{{ strtolower($event->title.' '.$event->description.' '.$event->location) }}" data-help-date="{{ $event->starts_at->timestamp }}" data-help-priority="1">
                        <div>
                            <p class="help-category">{{ $event->user->organization ?? 'Association partenaire' }}</p>
                            <h2><a href="{{ route('volunteer.event.detail', $event) }}">{{ $event->title }}</a></h2>
                            <p class="help-description">{{ $event->description ?: 'Une action solidaire ouverte aux bénéficiaires et bénévoles.' }}</p>
                            <p class="help-location">{{ $event->location }} · {{ $event->starts_at->format('d/m/Y à H\hi') }}</p>
                        </div>
                            <a href="{{ route('volunteer.event.detail', $event) }}" class="help-reserve-link">Voir l'événement →</a>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="help-list">
            @foreach ($services as $service)
                <article class="help-service-card" data-help-category="{{ $service['filter'] }}" data-help-text="{{ strtolower($service['title'].' '.$service['description'].' '.$service['location']) }}" data-help-date="{{ $loop->index }}" data-help-priority="{{ $loop->index + 1 }}">
                    <div>
                        <p class="help-category">{{ $service['category'] }}</p>
                            <h2><a href="{{ route('help.detail', $service['key']) }}">{{ $service['title'] }}</a></h2>
                        <p class="help-description">{{ $service['description'] }}</p>
                        <p class="help-location">{{ $service['location'] }}</p>

                        @if (isset($service['price']))
                            <div class="help-price" aria-label="Prix {{ $service['price'] }} au lieu de {{ $service['original_price'] }}">
                                <strong>{{ $service['price'] }}</strong>
                                <s>{{ $service['original_price'] }}</s>
                                <span>{{ $service['discount'] }}</span>
                            </div>
                        @endif

                        @if (isset($service['checks']))
                            <fieldset class="help-checklist">
                                <legend>Vérifier ma situation</legend>
                                @foreach ($service['checks'] as $check)
                                    <label>
                                        <input type="checkbox" name="guide-check-{{ $service['key'] }}-{{ $loop->index }}">
                                        <span>{{ $check }}</span>
                                    </label>
                                @endforeach
                            </fieldset>
                            <a href="{{ $service['guide_url'] }}" class="help-guide-link" target="_blank" rel="noopener noreferrer">{{ $service['guide_label'] }} ↗</a>
                        @endif
                    </div>

                    @auth
                        <form method="POST" action="{{ route('help.reserve') }}" class="help-booking-form" data-help-service="{{ $service['key'] }}">
                            @csrf
                            <input type="hidden" name="service" value="{{ $service['key'] }}">
                            <label>
                                <span>Date</span>
                                <input type="date" name="slot_date" min="{{ now()->toDateString() }}" value="{{ old('slot_date', now()->toDateString()) }}" required>
                            </label>
                            <label>
                                <span>Créneau</span>
                                <select name="slot_time" required>
                                    @foreach ($service['slots'] as $slot)
                                        <option value="{{ $slot }}" data-remaining="{{ $service['availability'][$slot] }}" @selected(old('slot_time') === $slot)>{{ $slot }} · {{ $service['availability'][$slot] }} places restantes</option>
                                    @endforeach
                                </select>
                                <small class="help-availability" data-help-availability></small>
                            </label>
                            <button type="submit" @disabled($service['availability'][$service['slots'][0]] === 0)>Réserver</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="help-reserve-link">Voir les créneaux →</a>
                    @endauth
                </article>
            @endforeach
        </div>
        <p class="help-no-results" data-help-no-results hidden>Aucun service ne correspond à votre recherche.</p>
    </section>
@endsection
