<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::view('/', 'home')->name('home');
Route::view('/besoin-aide', 'pages.help')->name('help');
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
    return view('pages.profile', ['user' => $request->user()]);
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
