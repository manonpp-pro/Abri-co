@extends('layouts.app')

@section('title', 'Inscription professionnel')
@section('minimal_layout', 'true')

@section('content')
    @php
        $editing = $editing ?? false;
        $profileUser = $user ?? null;
    @endphp

    <section class="registration-page professional-registration-page">
        <header class="registration-heading">
            <p>Espace Professionnel</p>
            <h1>{{ $editing ? 'Modifier mon profil' : 'Inscription' }}</h1>
        </header>
        @unless ($editing)
            <a href="{{ route('register.beneficiary') }}" class="registration-submit registration-login">Inscription bénéficiaire <span aria-hidden="true">←</span></a>
        @endunless
        <form class="registration-form" action="{{ $editing ? route('profile.update') : route('register.professional.store') }}" method="POST">
            @csrf
            <div class="registration-fields professional-fields">
                <label><span>Nom de l'association / entreprise</span><input type="text" name="organization" value="{{ old('organization', data_get($profileUser, 'organization')) }}" required></label>
                <label><span>SIRET / numéro RNA</span><input type="text" name="registration_number" value="{{ old('registration_number', data_get($profileUser, 'registration_number')) }}" required></label>
                <label><span>Site internet</span><input type="url" name="website" value="{{ old('website', data_get($profileUser, 'website')) }}"></label>
                <label><span>Adresse</span><input type="text" name="address" value="{{ old('address', data_get($profileUser, 'address')) }}" required></label>
                <label><span>Ville</span><input type="text" name="city" value="{{ old('city', data_get($profileUser, 'city')) }}" required></label>
                <label><span>Code postal</span><input type="text" name="postal_code" value="{{ old('postal_code', data_get($profileUser, 'postal_code')) }}" inputmode="numeric" required></label>
                <label><span>Nom et prénom du responsable</span><input type="text" name="manager_name" value="{{ old('manager_name', data_get($profileUser, 'manager_name')) }}" required></label>
                <label><span>Téléphone</span><input type="tel" name="phone" value="{{ old('phone', data_get($profileUser, 'phone')) }}" required></label>
                <label><span>E-mail</span><input type="email" name="email" value="{{ old('email', data_get($profileUser, 'email')) }}" required></label>
                <label><span>Mot de passe{{ $editing ? ' (laisser vide pour conserver l’actuel)' : '' }}</span><input type="password" name="password" minlength="8" @required(! $editing)></label>
            </div>
            <button type="submit" class="registration-submit">{{ $editing ? 'Enregistrer les modifications' : 'Enregistrer' }} <span aria-hidden="true">→</span></button>
            
        </form>
    </section>
@endsection
