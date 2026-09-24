@extends('layouts.app')

@section('title', 'Je suis une association')

@section('content')
    @if ($dashboard ?? false)
        <section class="association-dashboard mx-auto max-w-3xl py-6 sm:py-10">
            <header class="association-dashboard-header">
                <div>
                    <p>Espace association</p>
                    <h1>{{ $association->organization }}</h1>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Se déconnecter</button>
                </form>
            </header>

            @if (session('status'))
                <p class="association-status">{{ session('status') }}</p>
            @endif

            <nav class="association-tabs" aria-label="Espace association">
                <a class="{{ $tab === 'events' ? 'is-active' : '' }}" href="{{ route('association', ['tab' => 'events']) }}">Événements</a>
                <a class="{{ $tab === 'needs' ? 'is-active' : '' }}" href="{{ route('association', ['tab' => 'needs']) }}">Besoins live</a>
                <a class="{{ $tab === 'registrations' ? 'is-active' : '' }}" href="{{ route('association', ['tab' => 'registrations']) }}">Inscriptions</a>
                <a class="{{ $tab === 'profile' ? 'is-active' : '' }}" href="{{ route('association', ['tab' => 'profile']) }}">Profil</a>
            </nav>

            @if ($tab === 'events')
                <div class="association-panel">
                    <h2>Créer un événement</h2>
                    <form method="POST" action="{{ route('association.event.store') }}" class="association-form">
                        @csrf
                        <label><span>Nom de l'événement</span><input type="text" name="title" placeholder="Ex. Nom de l'événement" required></label>
                        <label><span>Lieu</span><input type="text" name="location" placeholder="Ex. Lieu..." required></label>
                        <label><span>Date & horaires</span><input type="datetime-local" name="starts_at" min="{{ now()->format('Y-m-d\TH:i') }}" required></label>
                        <label><span>Description</span><textarea name="description" rows="3" placeholder="Ex. Description..."></textarea></label>
                        <button type="submit">Publier →</button>
                    </form>
                </div>
                <div class="association-section-heading"><h2>Mes événements</h2></div>
                <div class="association-list">
                    @forelse ($events as $event)
                        <article class="association-list-card">
                            <div><h3>{{ $event->title }}</h3><p>{{ $event->location }} · {{ $event->starts_at->format('d/m/Y à H\hi') }}</p></div>
                            <span>Publié</span>
                        </article>
                    @empty
                        <p class="association-empty">Aucun événement publié pour le moment.</p>
                    @endforelse
                </div>
            @elseif ($tab === 'needs')
                <div class="association-panel">
                    <h2>Ajouter un besoin</h2>
                    <form method="POST" action="{{ route('association.need.store') }}" class="association-form">
                        @csrf
                        <label><span>Nom du besoin</span><input type="text" name="name" placeholder="Ex. Pâtes" required></label>
                        <div class="association-form-row"><label><span>Déjà reçu</span><input type="number" name="current_quantity" min="0" value="0" required></label><label><span>Objectif</span><input type="number" name="target_quantity" min="1" placeholder="100" required></label></div>
                        <label><span>Unité</span><input type="text" name="unit" value="unités" required></label>
                        <button type="submit">Ajouter au suivi →</button>
                    </form>
                </div>
                <div class="association-section-heading"><h2>Besoins en temps réel</h2></div>
                <div class="association-list">
                    @forelse ($needs as $need)
                        @php $progress = min(100, (int) round(($need->current_quantity / $need->target_quantity) * 100)); @endphp
                        <article class="association-need-card"><div><h3>{{ $need->name }}</h3><p>{{ $need->current_quantity }} / {{ $need->target_quantity }} {{ $need->unit }}</p></div><strong>{{ $progress }}%</strong><div class="association-progress"><span style="width: {{ $progress }}%"></span></div></article>
                    @empty
                        <p class="association-empty">Aucun besoin publié pour le moment.</p>
                    @endforelse
                </div>
            @elseif ($tab === 'registrations')
                <div class="association-stats"><div><strong>{{ $events->count() }}</strong><span>Événements publiés</span></div><div><strong>0</strong><span>Bénévoles inscrits</span></div><div><strong>0</strong><span>Créneaux ce mois</span></div><div><strong>0%</strong><span>Taux de présence</span></div></div>
                <div class="association-section-heading"><h2>Dernières inscriptions</h2></div>
                <p class="association-empty">Les inscriptions à vos événements apparaîtront ici.</p>
            @else
                <div class="association-profile-card"><div class="association-profile-initials">{{ mb_strtoupper(mb_substr($association->organization, 0, 2)) }}</div><h2>{{ $association->organization }}</h2><p>Association ou entreprise · {{ $association->city }}</p><p>{{ $association->email }}</p><a href="{{ route('profile.edit') }}">Modifier le profil →</a></div>
            @endif
        </section>
    @elseif ($personal ?? false)
        <section class="association-personal-page">
            <div class="association-personal-card">
                <span class="association-personal-icon" aria-hidden="true">♥</span>
                <p class="association-personal-eyebrow">Espace association</p>
                <h1>Cet espace est réservé aux associations.</h1>
                <p>Vous êtes connecté avec un compte bénéficiaire. Votre espace personnel reste accessible depuis votre profil.</p>
                <a href="{{ route('profile') }}">Retour à mon profil →</a>
            </div>
        </section>
    @else
        <section class="mx-auto max-w-4xl py-16 lg:py-24">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Les forces réunies vont plus loin</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-ink">Faites grandir vos actions avec Abri-co.</h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Créez votre espace association pour publier vos événements, suivre vos besoins et mobiliser des bénévoles.</p>
            <a href="{{ route('register.professional') }}" class="mt-10 inline-block rounded-full bg-ink px-6 py-3 font-semibold text-white transition hover:bg-coral">Inscrire mon association</a>
        </section>
    @endif
@endsection
