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

        <div class="help-list">
            @foreach ($services as $service)
                <article class="help-service-card" data-help-category="{{ $service['filter'] }}" data-help-text="{{ strtolower($service['title'].' '.$service['description'].' '.$service['location']) }}">
                    <div>
                        <p class="help-category">{{ $service['category'] }}</p>
                        <h2>{{ $service['title'] }}</h2>
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
                        <form method="POST" action="{{ route('help.reserve') }}" class="help-booking-form">
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
                                        <option value="{{ $slot }}" @selected(old('slot_time') === $slot)>{{ $slot }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <button type="submit">Réserver</button>
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
