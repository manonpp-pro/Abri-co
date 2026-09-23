<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/besoin-aide', 'pages.help')->name('help');
Route::view('/aider', 'pages.volunteer')->name('volunteer');
Route::view('/association', 'pages.association')->name('association');
Route::view('/inscription/beneficiaire', 'pages.register-beneficiary')->name('register.beneficiary');
Route::post('/inscription/beneficiaire', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8'],
        'need' => ['required', 'string', 'max:255'],
    ]);

    $user = User::create($validated);

    Auth::login($user);

    return to_route('profile');
})->name('register.beneficiary.store');
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
Route::post('/deconnexion', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return to_route('home');
})->middleware('auth')->name('logout');
Route::view('/inscription/professionnel', 'pages.register-professional')->name('register.professional');
