@extends('layouts.app')

@section('title', 'Connexion')
@section('minimal_layout', 'true')

@section('content')
    {{-- Les erreurs Laravel sont affichées sans jamais conserver le mot de passe saisi. --}}
    <section class="registration-page login-page">
        <header class="registration-heading">
            <p>Espace Personnel</p>
            <h1>Connexion</h1>
        </header>

        @if ($errors->any())
            <div class="registration-message registration-message-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="registration-form" action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="registration-fields login-fields">
                <label><span>Email</span><input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
                <label><span>Mot de passe</span><input type="password" name="password" minlength="8" required></label>
                <label class="login-remember"><input type="checkbox" name="remember" value="1"> <span>Se souvenir de moi</span></label>
            </div>
            <button type="submit" class="registration-submit">Se connecter <span aria-hidden="true">→</span></button>
            <a href="{{ route('register.beneficiary') }}" class="registration-submit registration-login">Inscription<span aria-hidden="true">→</span></a>
        </form>
    </section>
@endsection