@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <section class="hero-grid relative overflow-hidden rounded-[2rem] bg-ink px-6 py-12 text-white shadow-xl sm:px-10 lg:px-16 lg:py-20">
        <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-coral/20 blur-3xl"></div>
        <div class="relative max-w-2xl">
            <p class="mb-5 text-sm font-semibold uppercase tracking-[0.2em] text-mint">L'entraide, simplement</p>
            <h1 class="max-w-xl text-4xl font-semibold leading-tight tracking-tight sm:text-6xl">Personne ne devrait traverser une difficulté seul.</h1>
            <p class="mt-6 max-w-lg text-lg leading-8 text-slate-300">Abri-co met en relation les personnes qui ont besoin d'un soutien avec celles qui peuvent agir.</p>
            <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('help') }}" class="rounded-full bg-coral px-6 py-3 text-center font-semibold text-white transition hover:bg-coral-dark">J'ai besoin d'aide</a>
                <a href="{{ route('volunteer') }}" class="rounded-full border border-white/30 px-6 py-3 text-center font-semibold text-white transition hover:bg-white/10">Je veux aider</a>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mb-8 max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Un réseau ouvert</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Trois façons de rejoindre Abri-co</h2>
        </div>
        <div class="grid gap-5 md:grid-cols-3">
            <a href="{{ route('help') }}" class="group rounded-3xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <span class="text-3xl">01</span>
                <h3 class="mt-8 text-xl font-semibold text-ink">J'ai besoin d'aide</h3>
                <p class="mt-3 leading-7 text-slate-600">Trouvez une écoute, une ressource ou un accompagnement adapté à votre situation.</p>
                <span class="mt-6 inline-block font-semibold text-coral">Découvrir <span class="transition group-hover:ml-2">→</span></span>
            </a>
            <a href="{{ route('volunteer') }}" class="group rounded-3xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <span class="text-3xl">02</span>
                <h3 class="mt-8 text-xl font-semibold text-ink">Je veux aider</h3>
                <p class="mt-3 leading-7 text-slate-600">Proposez votre temps, vos compétences ou simplement votre présence.</p>
                <span class="mt-6 inline-block font-semibold text-coral">Participer <span class="transition group-hover:ml-2">→</span></span>
            </a>
            <a href="{{ route('association') }}" class="group rounded-3xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <span class="text-3xl">03</span>
                <h3 class="mt-8 text-xl font-semibold text-ink">Je suis une association</h3>
                <p class="mt-3 leading-7 text-slate-600">Faites connaître vos actions et construisez de nouvelles solidarités.</p>
                <span class="mt-6 inline-block font-semibold text-coral">Nous rejoindre <span class="transition group-hover:ml-2">→</span></span>
            </a>
        </div>
    </section>
