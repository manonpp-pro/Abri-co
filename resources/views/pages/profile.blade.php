@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    @php
        $nameParts = preg_split('/\s+/', trim($user->name));
        $initials = collect(array_slice($nameParts, 0, 2))
            ->map(fn (string $part): string => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
    @endphp

    <section class="profile-page mx-auto max-w-2xl py-8 sm:py-12">
        <div class="profile-heading flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-white/75">Espace personnel</p>
                <h1 class="mt-1 text-3xl font-bold text-white sm:text-4xl">{{ $user->name }}</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="profile-logout">Se déconnecter</button>
            </form>
        </div>

        <div class="profile-tab mt-7">Profil</div>

        <div class="profile-card mt-8">
            <div class="profile-initials">{{ $initials }}</div>
            <h2 class="mt-5 text-2xl font-bold text-[#421b10]">{{ $user->name }}</h2>
            <p class="mt-1 text-base text-[#c76d59]">{{ $user->created_at?->format('d/m/Y') }}</p>
        </div>

        <div class="mt-12 grid gap-5">
            <a href="#" class="profile-action">Modifier le profil <span aria-hidden="true">→</span></a>
            <a href="#" class="profile-action">Mes distributions passées <span aria-hidden="true">→</span></a>
            <a href="#" class="profile-action">Choisir langue <span aria-hidden="true">→</span></a>
        </div>
    </section>
@endsection