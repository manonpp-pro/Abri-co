@extends('layouts.app')

@section('title', 'Inscription professionnel')

@section('content')
    <section class="mx-auto max-w-xl py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Rejoindre le réseau</p>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-ink">Inscription professionnel</h1>
        <p class="mt-4 leading-7 text-slate-600">Professionnel indépendant ou membre d'une association, présentez votre activité et vos disponibilités.</p>
        <form class="mt-10 space-y-5 rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200 sm:p-9" action="#" method="POST">
            @csrf
            <label class="block"><span class="text-sm font-semibold text-ink">Nom complet</span><input type="text" name="name" class="form-field" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">E-mail professionnel</span><input type="email" name="email" class="form-field" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Structure ou association</span><input type="text" name="organization" class="form-field"></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Domaine d'intervention</span><input type="text" name="speciality" class="form-field" placeholder="Ex. médiation, santé, logement" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Mot de passe</span><input type="password" name="password" minlength="8" class="form-field" required><span class="mt-1 block text-xs text-slate-500">8 caractères minimum</span></label>
            <button type="submit" class="w-full rounded-full bg-ink px-6 py-3 font-semibold text-white transition hover:bg-coral">Rejoindre Abri-co</button>
        </form>
    </section>
@endsection
