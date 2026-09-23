<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/besoin-aide', 'pages.help')->name('help');
Route::view('/aider', 'pages.volunteer')->name('volunteer');
Route::view('/association', 'pages.association')->name('association');
Route::view('/inscription/beneficiaire', 'pages.register-beneficiary')->name('register.beneficiary');
Route::view('/inscription/professionnel', 'pages.register-professional')->name('register.professional');
