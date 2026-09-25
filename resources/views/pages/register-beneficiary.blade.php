@extends('layouts.app')

@section('title', 'Inscription bénéficiaire')
@section('minimal_layout', 'true')

@section('content')
    {{-- Le même formulaire sert à créer puis à modifier un profil bénéficiaire. --}}
    @php
        $editing = $editing ?? false;
        $profileUser = $user ?? null;
    @endphp

    <section class="registration-page">
        <header class="registration-heading">
            <p>Espace Personnel</p>
            <h1>{{ $editing ? 'Modifier mon profil' : 'Inscription' }}</h1>
        </header>


        @if (session('status'))
            <p class="registration-message registration-message-success">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <div class="registration-message registration-message-error">
                <p class="font-semibold">Le formulaire contient une erreur.</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="registration-form" action="{{ $editing ? route('profile.update') : route('register.beneficiary.store') }}" method="POST">
            @csrf
            <div class="registration-section-title">{{ $editing ? 'Modifier mon dossier individuel' : 'Remplir mon dossier individuel' }}</div>
            @unless ($editing)
                <a href="{{ route('register.professional') }}" class="registration-switch">Inscription professionnel / association <span aria-hidden="true">→</span></a>
            @endunless
            <div class="registration-fields">
                <label><span>Nom de famille</span><input type="text" name="name" value="{{ old('name', data_get($profileUser, 'name')) }}" required></label>
                <label><span>Prénom</span><input type="text" name="first_name" value="{{ old('first_name', data_get($profileUser, 'first_name')) }}" required></label>
                <label><span>Téléphone</span><input type="tel" name="phone" value="{{ old('phone', data_get($profileUser, 'phone')) }}" required></label>
                <fieldset>
                    <legend>Quel est ton genre ?</legend>
                    <div class="registration-options">
                        <label><input type="radio" name="gender" value="Femme" @checked(old('gender', data_get($profileUser, 'gender')) === 'Femme') required><span>Femme</span></label>
                        <label><input type="radio" name="gender" value="Homme" @checked(old('gender', data_get($profileUser, 'gender')) === 'Homme')><span>Homme</span></label>
                        <label><input type="radio" name="gender" value="Autre" @checked(old('gender', data_get($profileUser, 'gender')) === 'Autre')><span>Autre</span></label>
                    </div>
                </fieldset>
                <label><span>Quelle est ta date de naissance ?</span><input type="date" name="birth_date" value="{{ old('birth_date', data_get($profileUser, 'birth_date')?->format('Y-m-d')) }}" required></label>
                <label><span>Ta ville ?</span><input type="text" name="city" value="{{ old('city', data_get($profileUser, 'city')) }}" required></label>
                <label><span>Code postal</span><input type="text" name="postal_code" value="{{ old('postal_code', data_get($profileUser, 'postal_code')) }}" inputmode="numeric" required></label>
                <label><span>Ton école ou université ?</span><input type="text" name="school" value="{{ old('school', data_get($profileUser, 'school')) }}" required></label>
                <fieldset class="registration-email-section">
                    <legend>Email</legend>
                    <label><span>Adresse e-mail</span><input type="email" name="email" value="{{ old('email', data_get($profileUser, 'email')) }}" required></label>
                </fieldset>
                <label><span>Mot de passe{{ $editing ? ' (laisser vide pour conserver l’actuel)' : '' }}</span><input type="password" name="password" minlength="8" @required(! $editing)></label>
            </div>
            <button type="submit" class="registration-submit">{{ $editing ? 'Enregistrer les modifications' : 'Enregistrer' }}<span aria-hidden="true">→</span></button>
            @unless ($editing)
                <a href="{{ route('login') }}" class="registration-submit registration-login">Connexion<span aria-hidden="true">→</span></a>
            @endunless
        </form>
    </section>
@endsection
