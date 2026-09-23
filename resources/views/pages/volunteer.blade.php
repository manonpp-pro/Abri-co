@extends('layouts.app')

@section('title', 'Je veux aider')

@section('content')
    <section class="mx-auto max-w-4xl py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Votre temps a de la valeur</p>
        <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-ink sm:text-5xl">Aider peut commencer par une heure.</h1>
        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Choisissez la manière dont vous souhaitez contribuer. Abri-co vous mettra en relation avec des besoins concrets près de chez vous.</p>

        <div class="mt-12 grid gap-5 md:grid-cols-3">
            <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200"><h2 class="font-semibold text-ink">Donner du temps</h2><p class="mt-3 text-sm leading-6 text-slate-600">Accompagner, écouter ou rendre un service ponctuel.</p></div>
            <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200"><h2 class="font-semibold text-ink">Partager une compétence</h2><p class="mt-3 text-sm leading-6 text-slate-600">Transmettre vos connaissances à celles et ceux qui en ont besoin.</p></div>
            <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200"><h2 class="font-semibold text-ink">Créer du lien</h2><p class="mt-3 text-sm leading-6 text-slate-600">Être présent et participer à une communauté solidaire.</p></div>
        </div>
        <a href="{{ route('register.professional') }}" class="mt-10 inline-block rounded-full bg-coral px-6 py-3 font-semibold text-white transition hover:bg-coral-dark">Je m'inscris pour aider</a>
    </section>
@endsection
