@extends('layouts.app')

@section('title', 'Inscription bénéficiaire')

@section('content')
    <section class="mx-auto max-w-xl py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Créer un compte</p>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-ink">Inscription bénéficiaire</h1>
        <p class="mt-4 leading-7 text-slate-600">Votre compte vous permettra de trouver un accompagnement adapté à vos besoins.</p>
        <form class="mt-10 space-y-5 rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200 sm:p-9" action="#" method="POST">
            @csrf
            <label class="block"><span class="text-sm font-semibold text-ink">Nom complet</span><input type="text" name="name" class="form-field" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Adresse e-mail</span><input type="email" name="email" class="form-field" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Mot de passe</span><input type="password" name="password" class="form-field" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Votre besoin principal</span><select name="need" class="form-field"><option>Écoute et soutien</option><option>Accompagnement social</option><option>Accès aux droits</option><option>Autre besoin</option></select></label>
            <button type="submit" class="w-full rounded-full bg-coral px-6 py-3 font-semibold text-white transition hover:bg-coral-dark">Créer mon compte</button>
        </form>
    </section>
@endsection
