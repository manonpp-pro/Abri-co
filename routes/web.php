<?php

use App\Models\AssociationEvent;
use App\Models\AssociationNeed;
use App\Models\Donation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

// Catalogue public des aides. Les créneaux restent ici pour être réutilisés par l'affichage et la réservation.
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

// Ces opportunités servent de contenu de départ; les événements d'associations sont ensuite ajoutés depuis la base.
$volunteerOpportunities = [
    [
        'key' => 'distribution-paniers-saint-denis',
        'title' => 'Distribution paniers - Saint-Denis',
        'partner' => 'Fresque Solidaire',
        'date' => '2026-09-28',
        'display_date' => 'Sam 28 sep',
        'time' => '10h - 5 places',
        'slot' => '10:00 - 15:00',
    ],
    [
        'key' => 'tri-alimentaire-ivry',
        'title' => 'Tri alimentaire - Ivry-sur-Seine',
        'partner' => 'Banque Alimentaire 94',
        'date' => '2026-09-29',
        'display_date' => 'Dim 29 sep',
        'time' => '9h - 12 places',
        'slot' => '09:00 - 12:00',
    ],
    [
        'key' => 'collecte-monoprix-paris',
        'title' => 'Collecte Monoprix - Paris 11e',
        'partner' => 'Les Restos du Cœur',
        'date' => '2026-10-03',
        'display_date' => 'Jeu 3 oct',
        'time' => '16h - 3 places',
        'slot' => '16:00 - 19:00',
    ],
    [
        'key' => 'maraude-etudiante',
        'title' => 'Maraude étudiante nocturne',
        'partner' => 'UniSolidaire',
        'date' => '2026-10-04',
        'display_date' => 'Ven 4 oct',
        'time' => '22h - 8 places',
        'slot' => '22:00 - 00:00',
    ],
];

Route::get('/', function () {
    return view('home', [
        'partnerAssociations' => User::query()
            ->where('account_type', 'professional')
            ->whereNotNull('organization')
            ->orderBy('organization')
            ->get(['id', 'organization', 'city']),
    ]);
})->name('home');
Route::get('/besoin-aide', function () use ($helpServices) {
    // Chaque service reçoit son nombre de places restant avant d'être envoyé à la vue.
    $services = collect($helpServices)->map(function (array $service): array {
        $capacity = $service['capacity'] ?? 5;
        $availability = collect($service['slots'])->mapWithKeys(function (string $slot) use ($service, $capacity): array {
            $reserved = Reservation::query()
                ->where('service_key', $service['key'])
                ->whereDate('slot_date', today())
                ->where('slot_time', $slot)
                ->where('status', 'reserved')
                ->count();

            return [$slot => max(0, $capacity - $reserved)];
        })->all();

        return [...$service, 'capacity' => $capacity, 'availability' => $availability];
    })->all();

    return view('pages.help', [
        'services' => $services,
        'associationEvents' => AssociationEvent::with('user')->where('status', 'published')->where('starts_at', '>=', now())->orderBy('starts_at')->get(),
    ]);
})->name('help');
Route::get('/besoin-aide/{service}', function (string $service) use ($helpServices) {
    $helpService = collect($helpServices)->firstWhere('key', $service);
    abort_unless($helpService !== null, 404);

    return view('pages.post-detail', [
        'title' => $helpService['title'],
        'category' => $helpService['category'],
        'description' => $helpService['description'],
        'location' => $helpService['location'],
        'date' => null,
        'backRoute' => route('help'),
        'backLabel' => "Retour aux besoins d'aide",
    ]);
})->name('help.detail');
Route::get('/besoin-aide/{service}/disponibilite', function (Request $request, string $service) use ($helpServices) {
    $helpService = collect($helpServices)->firstWhere('key', $service);
    abort_unless($helpService !== null, 404);

    $validated = $request->validate([
        'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
    ]);
    $capacity = $helpService['capacity'] ?? 5;

    return response()->json(collect($helpService['slots'])->mapWithKeys(function (string $slot) use ($helpService, $validated, $capacity): array {
        $reserved = Reservation::query()
            ->where('service_key', $helpService['key'])
            ->whereDate('slot_date', $validated['date'])
            ->where('slot_time', $slot)
            ->where('status', 'reserved')
            ->count();

        return [$slot => max(0, $capacity - $reserved)];
    }));
})->name('help.availability');
Route::get('/aider', function () use ($volunteerOpportunities) {
    $opportunities = collect($volunteerOpportunities)->map(function (array $opportunity): array {
        $capacity = $opportunity['capacity'] ?? 5;
        $reserved = Reservation::query()
            ->where('service_key', 'volunteer-'.$opportunity['key'])
            ->whereDate('slot_date', $opportunity['date'])
            ->where('slot_time', $opportunity['slot'])
            ->where('status', 'reserved')
            ->count();

        return [...$opportunity, 'capacity' => $capacity, 'remaining' => max(0, $capacity - $reserved)];
    })->all();

    return view('pages.volunteer', [
        'opportunities' => $opportunities,
        'associationEvents' => AssociationEvent::with('user')->where('status', 'published')->where('starts_at', '>=', now())->orderBy('starts_at')->get(),
    ]);
})->name('volunteer');
Route::get('/aider/opportunite/{opportunity}', function (string $opportunity) use ($volunteerOpportunities) {
    $volunteerOpportunity = collect($volunteerOpportunities)->firstWhere('key', $opportunity);
    abort_unless($volunteerOpportunity !== null, 404);

    return view('pages.post-detail', [
        'title' => $volunteerOpportunity['title'],
        'category' => 'Bénévolat',
        'description' => 'Participez à cette action solidaire avec notre association partenaire.',
        'location' => $volunteerOpportunity['partner'],
        'date' => $volunteerOpportunity['display_date'].' · '.$volunteerOpportunity['slot'],
        'backRoute' => route('volunteer'),
        'backLabel' => 'Retour au bénévolat',
    ]);
})->name('volunteer.detail');
Route::get('/aider/evenement/{event}', function (AssociationEvent $event) {
    abort_unless($event->status === 'published', 404);

    return view('pages.post-detail', [
        'title' => $event->title,
        'category' => $event->category,
        'description' => $event->description ?: 'Un événement solidaire proposé par une association partenaire.',
        'location' => $event->location,
        'date' => $event->starts_at->format('d/m/Y à H\hi'),
        'backRoute' => route('volunteer'),
        'backLabel' => 'Retour au bénévolat',
    ]);
})->name('volunteer.event.detail');
Route::get('/association', function (Request $request) {
    if (! $request->user()) {
        return view('pages.association');
    }

    if ($request->user()->account_type !== 'professional') {
        return view('pages.association', ['personal' => true]);
    }

    $user = $request->user();

    // Une association ne voit que ses propres événements et besoins dans son espace de gestion.
    return view('pages.association', [
        'dashboard' => true,
        'association' => $user,
        'events' => AssociationEvent::where('user_id', $user->id)->orderBy('starts_at')->get()->each(function (AssociationEvent $event): void {
            $event->remaining_capacity = max(0, $event->capacity - Reservation::where('service_key', 'association-event-'.$event->id)->where('status', 'reserved')->count());
        }),
        'needs' => AssociationNeed::where('user_id', $user->id)->orderBy('created_at')->get(),
        'tab' => $request->query('tab', 'events'),
    ]);
})->name('association');
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
Route::post('/association/evenement', function (Request $request) {
    abort_unless($request->user()?->account_type === 'professional', 403);

    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'category' => ['required', Rule::in(['collecte', 'aide', 'anti-gaspi', 'benevolat'])],
        'location' => ['required', 'string', 'max:255'],
        'starts_at' => ['required', 'date_format:Y-m-d\\TH:i', 'after_or_equal:now'],
        'capacity' => ['required', 'integer', 'min:1', 'max:10000'],
        'event_type' => ['required', Rule::in(['one_time', 'recurring'])],
        'description' => ['nullable', 'string', 'max:2000'],
    ]);

    // L'utilisateur connecté devient automatiquement le propriétaire de la publication.
    AssociationEvent::create([...$validated, 'user_id' => $request->user()->id]);

    return to_route('association', ['tab' => 'events'])->with('status', 'Événement publié.');
})->middleware('auth')->name('association.event.store');
Route::post('/association/besoin', function (Request $request) {
    abort_unless($request->user()?->account_type === 'professional', 403);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'current_quantity' => ['required', 'integer', 'min:0'],
        'target_quantity' => ['required', 'integer', 'min:1'],
        'unit' => ['required', 'string', 'max:50'],
    ]);

    AssociationNeed::create([...$validated, 'user_id' => $request->user()->id]);

    return to_route('association', ['tab' => 'needs'])->with('status', 'Besoin ajouté au suivi.');
})->middleware('auth')->name('association.need.store');
Route::delete('/association/evenement/{event}', function (Request $request, AssociationEvent $event) {
    abort_unless($event->user_id === $request->user()->id, 403);

    $event->delete();

    return to_route('association', ['tab' => 'events'])->with('status', 'Événement supprimé.');
})->middleware('auth')->name('association.event.destroy');
Route::delete('/association/besoin/{need}', function (Request $request, AssociationNeed $need) {
    abort_unless($need->user_id === $request->user()->id, 403);

    $need->delete();

    return to_route('association', ['tab' => 'needs'])->with('status', 'Besoin supprimé.');
})->middleware('auth')->name('association.need.destroy');
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

    $capacity = $service['capacity'] ?? 5;
    $reservedCount = Reservation::query()
        ->where('service_key', $service['key'])
        ->whereDate('slot_date', $validated['slot_date'])
        ->where('slot_time', $validated['slot_time'])
        ->where('status', 'reserved')
        ->count();

    if ($reservedCount >= $capacity) {
        return back()->withErrors(['slot_time' => 'Ce créneau est complet.'])->withInput();
    }

    // firstOrCreate évite qu'un double clic crée deux réservations identiques.
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
Route::post('/aider/inscription', function (Request $request) use ($volunteerOpportunities) {
    $validated = $request->validate([
        'opportunity' => ['required', Rule::in(array_column($volunteerOpportunities, 'key'))],
    ]);

    $opportunity = collect($volunteerOpportunities)->firstWhere('key', $validated['opportunity']);
    $capacity = $opportunity['capacity'] ?? 5;
    $reservedCount = Reservation::query()
        ->where('service_key', 'volunteer-'.$opportunity['key'])
        ->whereDate('slot_date', $opportunity['date'])
        ->where('slot_time', $opportunity['slot'])
        ->where('status', 'reserved')
        ->count();

    if ($reservedCount >= $capacity) {
        return back()->withErrors(['opportunity' => 'Ce créneau bénévole est complet.'])->withInput();
    }

    $reservation = Reservation::firstOrCreate([
        'user_id' => $request->user()->id,
        'service_key' => 'volunteer-'.$opportunity['key'],
        'slot_date' => $opportunity['date'],
        'slot_time' => $opportunity['slot'],
    ], [
        'service_name' => $opportunity['title'],
    ]);

    $message = $reservation->wasRecentlyCreated
        ? 'Votre inscription bénévole est confirmée.'
        : 'Vous êtes déjà inscrit à ce créneau.';

    return to_route('volunteer')->with('status', $message);
})->middleware('auth')->name('volunteer.join');
Route::post('/aider/inscription-evenement', function (Request $request) {
    $validated = $request->validate([
        'event' => ['required', 'integer', Rule::exists('association_events', 'id')->where('status', 'published')],
    ]);

    // On relit l'événement en base pour ne jamais faire confiance aux données envoyées par le navigateur.
    $event = AssociationEvent::where('status', 'published')->findOrFail($validated['event']);
    $reservedCount = Reservation::query()
        ->where('service_key', 'association-event-'.$event->id)
        ->where('status', 'reserved')
        ->count();

    if ($reservedCount >= $event->capacity) {
        return back()->withErrors(['event' => 'Cet événement est complet.'])->withInput();
    }

    $reservation = Reservation::firstOrCreate([
        'user_id' => $request->user()->id,
        'service_key' => 'association-event-'.$event->id,
        'slot_date' => $event->starts_at->toDateString(),
        'slot_time' => $event->starts_at->format('H:i'),
    ], [
        'service_name' => $event->title,
    ]);

    $message = $reservation->wasRecentlyCreated
        ? 'Votre inscription à l’événement est confirmée.'
        : 'Vous êtes déjà inscrit à cet événement.';

    return to_route('volunteer')->with('status', $message);
})->middleware('auth')->name('volunteer.event.join');
Route::post('/profil/reservation/{reservation}/annuler', function (Request $request, Reservation $reservation) {
    abort_unless($reservation->user_id === $request->user()->id, 403);

    $reservation->delete();

    return to_route('profile')->with('status', 'Votre réservation a été annulée.');
})->middleware('auth')->name('reservation.cancel');
Route::view('/don', 'pages.donation')->name('donation.create');
Route::post('/don', function (Request $request) {
    $validated = $request->validate([
        'donor_type' => ['required', Rule::in(['individual', 'organization'])],
        'donation_type' => ['required', Rule::in(['financial', 'food'])],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'organization' => ['nullable', 'required_if:donor_type,organization', 'string', 'max:255'],
        'amount' => ['nullable', 'required_if:donation_type,financial', 'numeric', 'min:1', 'max:999999.99'],
        'description' => ['nullable', 'required_if:donation_type,food', 'string', 'max:2000'],
    ]);

    Donation::create([...$validated, 'user_id' => $request->user()?->id]);

    return to_route('donation.create')->with('status', 'Votre proposition de don a bien été envoyée.');
})->name('donation.store');
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
    $user = $request->user();

    return view('pages.profile', [
        'user' => $user,
        'reservations' => Reservation::query()
            ->where('user_id', $user->id)
            ->where('slot_date', '>=', today())
            ->orderBy('slot_date')
            ->get(),
        'donations' => Donation::query()
            ->where('user_id', $user->id)
            ->latest()
            ->get(),
        'receivedDonationCount' => $user->account_type === 'professional'
            ? Donation::query()->where('organization', $user->organization)->count()
            : 0,
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
