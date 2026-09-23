@extends('layouts.app')

@section('title', "J'ai besoin d'aide")

@section('content')
    <section class="mx-auto max-w-3xl py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Vous n'êtes pas seul·e</p>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-ink sm:text-5xl">De quoi avez-vous besoin aujourd'hui ?</h1>
        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Quelques informations suffisent pour vous orienter vers le bon accompagnement. Vous pourrez préciser votre situation ensuite.</p>

        <div class="mt-12 grid gap-4 sm:grid-cols-2">
            <a href="{{ route('register.beneficiary') }}" class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:ring-coral">
                <h2 class="text-xl font-semibold text-ink">Être écouté·e</h2>
                <p class="mt-3 leading-7 text-slate-600">Parler à quelqu'un et ne plus rester seul face à une difficulté.</p>
                <span class="mt-6 inline-block font-semibold text-coral">Créer mon compte →</span>
            </a>
            <a href="{{ route('register.beneficiary') }}" class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:ring-coral">
                <h2 class="text-xl font-semibold text-ink">Trouver un accompagnement</h2>
                <p class="mt-3 leading-7 text-slate-600">Accéder à des ressources et des personnes qui peuvent vous aider.</p>
                <span class="mt-6 inline-block font-semibold text-coral">Créer mon compte →</span>
            </a>
        </div>
    </section>
@endsection
