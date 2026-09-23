@extends('layouts.app')

@section('title', 'Inscription bénéficiaire')

@section('content')
    <section class="mx-auto max-w-xl py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Créer un compte</p>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-ink">Inscription bénéficiaire</h1>
        <p class="mt-4 leading-7 text-slate-600">Votre compte vous permettra de trouver un accompagnement adapté à vos besoins.</p>
        @if (session('status'))
            <p class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <div class="mt-6 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Le formulaire contient une erreur.</p>
                <ul class="mt-1 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="mt-10 space-y-5 rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200 sm:p-9" action="{{ route('register.beneficiary.store') }}" method="POST">
            @csrf
            <label class="block"><span class="text-sm font-semibold text-ink">Nom complet</span><input type="text" name="name" value="{{ old('name') }}" class="form-field" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Adresse e-mail</span><input type="email" name="email" value="{{ old('email') }}" class="form-field" required></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Mot de passe</span><input type="password" name="password" minlength="8" class="form-field" required><span class="mt-1 block text-xs text-slate-500">8 caractères minimum</span></label>
            <label class="block"><span class="text-sm font-semibold text-ink">Votre besoin principal</span><select name="need" class="form-field"><option value="Écoute et soutien" @selected(old('need') === 'Écoute et soutien')>Écoute et soutien</option><option value="Accompagnement social" @selected(old('need') === 'Accompagnement social')>Accompagnement social</option><option value="Accès aux droits" @selected(old('need') === 'Accès aux droits')>Accès aux droits</option><option value="Autre besoin" @selected(old('need') === 'Autre besoin')>Autre besoin</option></select></label>
            <button type="submit" class="w-full rounded-full bg-coral px-6 py-3 font-semibold text-white transition hover:bg-coral-dark">Créer mon compte</button>
        </form>
    </section>
@endsection
