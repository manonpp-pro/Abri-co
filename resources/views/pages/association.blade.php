@extends('layouts.app')

@section('title', 'Je suis une association')

@section('content')
    <section class="mx-auto max-w-4xl py-16 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-coral">Les forces réunies vont plus loin</p>
        <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-ink sm:text-5xl">Faites grandir vos actions avec Abri-co.</h1>
        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Présentez vos missions, recevez des demandes adaptées et rejoignez un réseau d'acteurs engagés.</p>

        <div class="mt-12 rounded-[2rem] bg-mint/50 p-8 sm:p-10">
            <h2 class="text-2xl font-semibold text-ink">Ce que votre association peut faire</h2>
            <ul class="mt-6 grid gap-4 text-slate-700 sm:grid-cols-2">
                <li>✓ Présenter ses services et ses horaires</li>
                <li>✓ Recevoir des demandes d'accompagnement</li>
                <li>✓ Publier ses besoins en bénévoles</li>
                <li>✓ Échanger avec les professionnels du réseau</li>
            </ul>
        </div>
        <a href="{{ route('register.professional') }}" class="mt-10 inline-block rounded-full bg-ink px-6 py-3 font-semibold text-white transition hover:bg-coral">Inscrire mon association</a>
    </section>
@endsection
