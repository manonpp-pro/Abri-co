<?php

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

$helpServices = [
    [
        'key' => 'collecte-solidaire',
        'filter' => 'collectes',
        'title' => 'Collecte solidaire',
        'category' => 'Alimentation',
        'description' => 'Paniers alimentaires proposés par des partenaires locaux.',
        'location' => 'Bordeaux centre',
        'slots' => ['10:00 - 11:00', '11:30 - 12:30', '14:00 - 15:00'],
    ],
    [
        'key' => 'colis-fruits-semaine',
        'filter' => 'collectes',
        'title' => 'Colis fruits de la semaine',
        'category' => 'Collecte alimentaire',
        'description' => 'Un colis de produits frais distribué chaque semaine.',
        'location' => 'Bordeaux centre',
        'slots' => ['09:00 - 10:00', '11:00 - 12:00', '15:00 - 16:00'],
    ],
    [
        'key' => 'collecte-boulangerie',
        'filter' => 'collectes',
        'title' => 'Collecte boulangerie du soir',
        'category' => 'Collecte alimentaire',
        'description' => 'Pains et invendus du jour proposés à prix solidaire.',
        'location' => 'Bordeaux sud',
        'slots' => ['18:00 - 19:00', '19:00 - 20:00'],
    ],
    [
        'key' => 'epicerie-solidaire',
        'filter' => 'anti-gaspi',
        'title' => 'Épicerie solidaire',
        'category' => 'Alimentation',
        'description' => 'Accédez à des produits essentiels à prix réduit.',
        'location' => 'Saint-Denis',
        'price' => '1 €',
        'original_price' => '6 €',
        'discount' => '-83%',
        'slots' => ['09:30 - 10:30', '13:30 - 14:30', '16:00 - 17:00'],
    ],
    [
        'key' => 'panier-legumes-bio',
        'filter' => 'anti-gaspi',
        'title' => 'Panier légumes bio',
        'category' => 'Anti-gaspi',
        'description' => 'Légumes invendus récupérés auprès de producteurs locaux.',
        'location' => 'Marché solidaire Ivry',
        'price' => '2,50 €',
        'original_price' => '12 €',
        'discount' => '-79%',
        'slots' => ['10:00 - 11:00', '14:00 - 15:00'],
    ],
    [
        'key' => 'produits-laitiers',
        'filter' => 'anti-gaspi',
        'title' => 'Box produits laitiers',
        'category' => 'Anti-gaspi',
        'description' => 'Produits laitiers proches de leur date à prix réduit.',
        'location' => 'Monoprix Saint-Denis',
        'price' => '1 €',
        'original_price' => '6 €',
        'discount' => '-83%',
        'slots' => ['10:30 - 11:30', '15:30 - 16:30'],
    ],
    [
        'key' => 'aide-crous',
        'filter' => 'aides',
        'title' => 'Aides CAF & CROUS',
        'category' => 'Droits et démarches',
        'description' => 'Un accompagnement pour vos démarches et vos droits.',
        'location' => 'En ligne',
        'checks' => ['Je suis étudiant·e', 'Je cherche une aide financière', 'Je veux être accompagné·e'],
        'guide_url' => 'https://www.caf.fr/allocataires/aides-et-demarches',
        'guide_label' => 'Guide CAF officiel',
        'slots' => ['10:00 - 11:00', '15:00 - 16:00'],
    ],
    [
        'key' => 'simulateur-droits',
        'filter' => 'aides',
        'title' => 'Simulateur rapide',
        'category' => 'Droits et démarches',
        'description' => 'Identifiez les aides auxquelles vous pouvez prétendre.',
        'location' => 'En ligne',
        'checks' => ['Boursier·ère CROUS', 'Moins de 26 ans', 'En location'],
        'guide_url' => 'https://www.etudiant.gouv.fr/fr/aides-financieres',
        'guide_label' => 'Guide étudiant officiel',
        'slots' => ['09:00 - 10:00', '14:00 - 15:00'],
    ],
    [
        'key' => 'guichet-unique',
        'filter' => 'aides',
        'title' => 'Guichet unique étudiant',
        'category' => 'Droits et démarches',
        'description' => 'Un rendez-vous pour être orienté vers le bon service.',
        'location' => 'CROUS Bordeaux',
        'checks' => ['Je veux parler à un conseiller', 'Je cherche une aide logement', 'Je prépare mon dossier'],
        'guide_url' => 'https://www.crous-bordeaux.fr/',
        'guide_label' => 'Site du CROUS Bordeaux',
        'slots' => ['10:00 - 11:00', '13:00 - 14:00', '16:00 - 17:00'],
    ],
    [
        'key' => 'panier-petit-budget',
        'filter' => 'petit-budget',
        'title' => 'Panier petit budget',
        'category' => 'Petit budget',
        'description' => 'Des produits essentiels à prix réduit pour vos courses.',
        'location' => 'Bordeaux nord',
        'slots' => ['10:30 - 11:30', '14:30 - 15:30'],
    ],
    [
        'key' => 'repas-etudiant',
        'filter' => 'petit-budget',
        'title' => 'Repas étudiant à petit prix',
        'category' => 'Petit budget',
        'description' => 'Des repas équilibrés à tarif solidaire près de chez vous.',
        'location' => 'Restaurant universitaire',
        'slots' => ['11:30 - 12:30', '12:30 - 13:30'],
    ],
    [
        'key' => 'transport-solidaire',
        'filter' => 'petit-budget',
        'title' => 'Transport solidaire',
        'category' => 'Petit budget',
        'description' => 'Trouvez une solution de transport adaptée à votre budget.',
        'location' => 'Bordeaux métropole',
        'slots' => ['09:00 - 10:00', '14:00 - 15:00'],
    ],
];

Route::view('/', 'home')->name('home');
Route::get('/besoin-aide', function () use ($helpServices) {
    return view('pages.help', ['services' => $helpServices]);
})->name('help');
Route::view('/aider', 'pages.volunteer')->name('volunteer');
Route::view('/association', 'pages.association')->name('association');
Route::view('/inscription/beneficiaire', 'pages.register-beneficiary')->name('register.beneficiary');
Route::post('/inscription/beneficiaire', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'first_name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:50'],
        'gender' => ['required', 'string', 'max:50'],
        'birth_date' => ['required', 'date'],
        'city' => ['required', 'string', 'max:255'],
        'postal_code' => ['required', 'string', 'max:20'],
        'school' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8'],
    ]);

    $user = User::create([...$validated, 'account_type' => 'beneficiary']);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('profile');
})->name('register.beneficiary.store');
Route::post('/inscription/professionnel', function (Request $request) {
    $validated = $request->validate([
        'organization' => ['required', 'string', 'max:255'],
        'registration_number' => ['required', 'string', 'max:100'],
        'website' => ['nullable', 'url', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'postal_code' => ['required', 'string', 'max:20'],
        'manager_name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:50'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8'],
    ]);

    $user = User::create([...$validated, 'name' => $validated['manager_name'], 'account_type' => 'professional']);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('profile');
})->name('register.professional.store');
Route::post('/besoin-aide/reservation', function (Request $request) use ($helpServices) {
    $validated = $request->validate([
        'service' => ['required', Rule::in(array_column($helpServices, 'key'))],
        'slot_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        'slot_time' => ['required', 'string'],
    ]);

    $service = collect($helpServices)->firstWhere('key', $validated['service']);

    if (! in_array($validated['slot_time'], $service['slots'], true)) {
        return back()->withErrors(['slot_time' => 'Ce créneau n’est pas disponible pour ce service.'])->withInput();
    }

    $reservation = Reservation::firstOrCreate([
        'user_id' => $request->user()->id,
        'service_key' => $service['key'],
        'slot_date' => $validated['slot_date'],
        'slot_time' => $validated['slot_time'],
    ], [
        'service_name' => $service['title'],
    ]);

    $message = $reservation->wasRecentlyCreated
        ? 'Votre créneau est réservé.'
        : 'Vous avez déjà réservé ce créneau.';

    return to_route('help')->with('status', $message);
})->middleware('auth')->name('help.reserve');
Route::view('/connexion', 'pages.login')->name('login');
Route::post('/connexion', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:8'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors(['email' => 'Ces identifiants ne correspondent pas à nos comptes.'])->onlyInput('email');
    }

    $request->session()->regenerate();

    return to_route('profile');
})->name('login.store');
Route::get('/profil', function (Request $request) {
    return view('pages.profile', [
        'user' => $request->user(),
        'reservations' => Reservation::query()
            ->where('user_id', $request->user()->id)
            ->where('slot_date', '>=', today())
            ->orderBy('slot_date')
            ->get(),
    ]);
})->middleware('auth')->name('profile');
Route::get('/profil/modifier', function (Request $request) {
    $user = $request->user();
    $view = $user->account_type === 'professional' ? 'pages.register-professional' : 'pages.register-beneficiary';

    return view($view, ['user' => $user, 'editing' => true]);
})->middleware('auth')->name('profile.edit');
Route::post('/profil/modifier', function (Request $request) {
    $user = $request->user();

    if ($user->account_type === 'professional') {
        $validated = $request->validate([
            'organization' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'manager_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $validated['name'] = $validated['manager_name'];
    } else {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'string', 'max:50'],
            'birth_date' => ['required', 'date'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'school' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);
    }

    if ($request->filled('password')) {
        $validated['password'] = $request->validate(['password' => ['string', 'min:8']])['password'];
    }

    $user->update($validated);

    return redirect()->route('profile')->with('status', 'Profil enregistré.');
})->middleware('auth')->name('profile.update');
Route::get('/langue', function (Request $request) {
    $request->session()->put('locale', $request->session()->get('locale') === 'en' ? 'fr' : 'en');

    return back();
})->middleware('auth')->name('language.toggle');
Route::post('/deconnexion', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return to_route('home');
})->middleware('auth')->name('logout');
Route::view('/inscription/professionnel', 'pages.register-professional')->name('register.professional');
