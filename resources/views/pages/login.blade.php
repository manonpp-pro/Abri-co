@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <section class="mx-auto max-w-xl py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Espace personnel</p>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-ink">Se connecter</h1>
        <p class="mt-4 leading-7 text-slate-600">Retrouvez votre profil et vos informations personnelles.</p>

        @if ($errors->any())
            <div class="mt-6 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="mt-10 space-y-5 rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200 sm:p-9" action="{{ route('login.store') }}" method="POST">
            @csrf
            <label class="block"><span class="text-sm font-semibold text-ink">Adresse e-mail</span><input type="email" name="email" value="{{ old('email') }}" class="form-field" required autofocus></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Mot de passe</span><input type="password" name="password" minlength="8" class="form-field" required><span class="mt-1 block text-xs text-slate-500">8 caractères minimum</span></label>
            <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" name="remember" value="1" class="accent-coral"> Se souvenir de moi</label>
            <button type="submit" class="w-full rounded-full bg-coral px-6 py-3 font-semibold text-white transition hover:bg-coral-dark">Se connecter</button>
        </form>
    </section>
@endsection