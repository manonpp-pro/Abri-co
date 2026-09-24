@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    @php
        $displayName = trim($user->name.' '.$user->first_name);
        $nameParts = preg_split('/\s+/', $displayName);
        $initials = collect(array_slice($nameParts, 0, 2))
            ->map(fn (string $part): string => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
        $isEnglish = session('locale') === 'en';
        $isProfessional = $user->account_type === 'professional';
        $reservationGroups = [
            [
                'title' => 'Mes engagements bénévoles',
                'icon' => '🤝',
                'id' => 'volunteer-reservations-title',
                'reservations' => $reservations->filter(fn ($reservation): bool => str_starts_with($reservation->service_key, 'volunteer-')),
            ],
            [
                'title' => 'Mes collectes et aides',
                'icon' => '♥',
                'id' => 'help-reservations-title',
                'reservations' => $reservations->filter(fn ($reservation): bool => ! str_starts_with($reservation->service_key, 'volunteer-')),
            ],
        ];
    @endphp

    <section class="profile-page mx-auto max-w-2xl py-8 sm:py-12">
        <div class="profile-heading flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-white/75">{{ $isEnglish ? 'Personal space' : ($isProfessional ? 'Espace professionnel' : 'Espace personnel') }}</p>
                <h1 class="mt-1 text-3xl font-bold text-white sm:text-4xl">{{ $displayName }}</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="profile-logout">Se déconnecter</button>
            </form>
        </div>

        <div class="profile-tab mt-7">{{ $isEnglish ? 'Profile' : 'Profil' }}</div>

        <div class="profile-card mt-8">
            <div class="profile-initials">{{ $initials }}</div>
            <h2 class="mt-5 text-2xl font-bold text-[#421b10]">{{ $displayName }}</h2>
            <p class="mt-1 text-base text-[#c76d59]">{{ $user->created_at?->format('d/m/Y') }}</p>
        </div>

        @if (session('status'))
            <p class="profile-status">{{ session('status') }}</p>
        @endif

        @unless ($isProfessional)
            <section class="profile-distributions" aria-labelledby="reservations-title">
                <h2 id="reservations-title">Mes créneaux réservés</h2>
                @foreach ($reservationGroups as $group)
                    <section class="profile-reservation-group" aria-labelledby="{{ $group['id'] }}">
                        <h3><span aria-hidden="true">{{ $group['icon'] }}</span> {{ $group['title'] }}</h3>
                        <div class="profile-distribution-grid">
                            @forelse ($group['reservations'] as $reservation)
                                <article class="profile-distribution-card">
                                    <span aria-hidden="true">✓</span>
                                    <div>
                                        <h4>{{ $reservation->service_name }}</h4>
                                        <p>{{ $reservation->slot_date->format('d/m/Y') }} · {{ $reservation->slot_time }}</p>
                                    </div>
                                </article>
                            @empty
                                <p class="profile-empty-state">Aucun créneau dans cette catégorie.</p>
                            @endforelse
                        </div>
                    </section>
                @endforeach
            </section>
        @endunless

        @unless ($isProfessional)
            <section class="profile-distributions" aria-labelledby="distributions-title">
                <h2 id="distributions-title">{{ $isEnglish ? 'My past distributions' : 'Mes distributions passées' }}</h2>
                <div class="profile-distribution-grid">
                    @foreach (['Collecte alimentaire', 'Colis étudiant', 'Distribution solidaire', 'Épicerie sociale', 'Repas partagé'] as $distribution)
                        <article class="profile-distribution-card">
                            <span aria-hidden="true">♥</span>
                            <div>
                                <h3>{{ $isEnglish ? ['Food collection', 'Student package', 'Solidarity distribution', 'Social grocery', 'Shared meal'][$loop->index] : $distribution }}</h3>
                                <p>{{ $isEnglish ? 'Completed' : 'Distribution terminée' }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endunless

        <div class="mt-12 grid gap-5">
            <a href="{{ route('profile.edit') }}" class="profile-action">{{ $isEnglish ? 'Edit profile' : 'Modifier le profil' }} <span aria-hidden="true">→</span></a>
            <a href="{{ route('language.toggle') }}" class="profile-action">{{ $isEnglish ? 'Language: French' : 'Choisir la langue : anglais' }} <span aria-hidden="true">→</span></a>
        </div>
    </section>
@endsection