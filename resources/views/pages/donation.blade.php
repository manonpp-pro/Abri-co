@extends('layouts.app')

@section('title', 'Proposer un don')

@section('content')
    <section class="donation-page mx-auto max-w-2xl py-8 sm:py-12">
        
         <!-- En-tête avec titre et sous-titre  -->
        <div class="donation-hero">
            <p>Je veux aider</p>
            <h1>Proposer un don</h1>
            <span aria-hidden="true">♥</span>
        </div>

        <!-- Message de confirmation après l'envoi du formulaire -->
        @if (session('status'))
            <p class="donation-status">{{ session('status') }}</p>
        @endif

        <!-- Bloc d'alerte si on oublie une/Des informations  -->
        @if ($errors->any())
            <div class="donation-errors">
                <strong>Vérifiez les informations saisies.</strong>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulaire de don  -->
        <form method="POST" action="{{ route('donation.store') }}" class="donation-form" data-donation-form>
            @csrf

            <!-- Étape 1 : Choix du type de donateur  -->
            <fieldset>
                <legend>Je suis...</legend>
                <div class="donation-choice-grid">
                    <label class="donation-choice">
                        <input type="radio" name="donor_type" value="individual" @checked(old('donor_type', 'individual') === 'individual')>
                        <span>Un particulier</span>
                    </label>
                    <label class="donation-choice">
                        <input type="radio" name="donor_type" value="organization" @checked(old('donor_type') === 'organization')>
                        <span>Une association / entreprise</span>
                    </label>
                </div>
            </fieldset>

            <!-- Étape 2 : Choix du type de don -->
            <fieldset>
                <legend>Je souhaite donner...</legend>
                <div class="donation-choice-grid">
                    <label class="donation-choice">
                        <input type="radio" name="donation_type" value="financial" @checked(request('type', old('donation_type', 'financial')) === 'financial')>
                        <span>De l'argent</span>
                    </label>
                    <label class="donation-choice">
                        <input type="radio" name="donation_type" value="food" @checked(request('type', old('donation_type')) === 'food')>
                        <span>Des denrées</span>
                    </label>
                </div>
            </fieldset>

            <!-- Coordonnées du donateur -->
            <div class="donation-fields-grid">
                <label><span>Nom complet</span><input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" required></label>
                <label><span>E-mail</span><input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required></label>
            </div>

            <!-- Champ affiché si le donateur est une association ou entreprise -->
            <label data-donor-organization><span>Nom de l'association ou de l'entreprise</span><input type="text" name="organization" value="{{ old('organization') }}"></label>

            <!-- Champ affiché si le donateur choisit un don d'argent  -->
            <label data-donation-financial><span>Montant du don (€)</span><input type="number" name="amount" value="{{ old('amount') }}" min="1" step="0.01" placeholder="Ex. 25"></label>

            <!-- Champ affiché si le donateur choisit un don de denrées -->
            <label data-donation-food><span>Que souhaitez-vous donner ?</span><textarea name="description" rows="4" placeholder="Ex. 20 paniers repas, produits d'hygiène...">{{ old('description') }}</textarea></label>

            <!-- Bouton de validation et note d'information  -->
            <button type="submit" class="donation-submit">Envoyer ma proposition →</button>
            <p class="donation-note">Nous vous recontacterons par e-mail pour organiser le don.</p>
        </form>
    </section>
@endsection