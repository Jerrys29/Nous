<?php

use App\Http\Controllers\NousController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\karaokeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Nous/index');
});
Route::get('profils', function () {
    return view('Nous/profils');
});

Route::get('register', function () {
    return view('Nous/register');
});
Route::get('terms', function () {
    return view('Nous/terms');
});

Route::get('/edit', 'App\Http\Controllers\NousController@edit')->name('edit');
Route::post('/register', 'App\Http\Controllers\NousController@store')->name('inscription.store');
Route::get('/login', 'App\Http\Controllers\NousController@loginview')->name('login');
Route::post('/login', 'App\Http\Controllers\NousController@login')->name('login');
Route::get('/profils', 'App\Http\Controllers\NousController@view')->name('profils');
Route::get('/profil/{userId}', 'App\Http\Controllers\NousController@detail')->name('profil');

Route::put('/update-name/{id}', 'App\Http\Controllers\NousController@updatename')->name('update-name');
Route::put('/update-numero/{id}', 'App\Http\Controllers\NousController@updatenumero')->name('update-numero');
Route::put('/update-pseudo/{id}', 'App\Http\Controllers\NousController@updatepseudo')->name('update-pseudo');
Route::put('/update-age/{id}', 'App\Http\Controllers\NousController@updateage')->name('update-age');
Route::put('/update-about/{id}', 'App\Http\Controllers\NousController@updateabout')->name('update-about');
Route::put('/update-interests/{id}', 'App\Http\Controllers\NousController@updateinterests')->name('update-interests');
Route::post('/store-images1', 'App\Http\Controllers\NousController@storephoto1')->name('store-images1')->middleware('web');
Route::post('/store-images2', 'App\Http\Controllers\NousController@storephoto2')->name('store-images2')->middleware('web');
Route::post('/store-images3', 'App\Http\Controllers\NousController@storephoto3')->name('store-images3')->middleware('web');
Route::post('/store-images4', 'App\Http\Controllers\NousController@storephoto4')->name('store-images4')->middleware('web');
Route::post('/store-images5', 'App\Http\Controllers\NousController@storephoto5')->name('store-images5')->middleware('web');

Route::post('/like-profile/{profile_id}', 'App\Http\Controllers\NousController@likeProfile')->name('like-profile');
Route::post('/unlike-profile/{profile_id}', 'App\Http\Controllers\NousController@unlikeProfile')->name('unlike-profile');
Route::post('/logout', 'App\Http\Controllers\NousController@logout')->name('logout');


Route::get('/mettre-a-jour-paiement','App\Http\Controllers\NousController@mettreAJourPaiement');


/* A D M I N */


Route::get('admin', function () {
    return view('Admin/login');
});
Route::get('utilisateurs', function () {
    return view('Admin/users');
});




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Nous/index');
});
Route::get('profils', function () {
    return view('Nous/profils');
});
Route::get('profil', function () {
    return view('Nous/detail');
});
Route::get('register', function () {
    return view('Nous/register');
});
Route::get('terms', function () {
    return view('Nous/terms');
});


/*E S P A C E K A R A O K E */
Route::get('kprofil', 'App\Http\Controllers\karaokeController@showprofil')->name('kprofil');




Route::get('karaoke', function () {
    return view('Karaoke/index');
});

Route::get('inscription', function () {
    return view('Karaoke/InscriKaraoke');
});
Route::get('connection', function () {
    return view('Karaoke/login')->name('connection');;
});
Route::get('formulaire', function () {
    return view('Karaoke/formulaire');
});
Route::get('/inscription', 'App\Http\Controllers\karaokeController@showRegistration')->name('inscription');
// web.php


   


//route vers mise à jour du profil
Route::post('/update-profile', 'App\Http\Controllers\karaokeController@updateProfile')->name('update-profile');


//page index
// Ajoutez cette ligne dans votre fichier web.php
Route::get('/index', 'App\Http\Controllers\karaokeController@showAllKaraokeProfiles')->name('karaokeusers');



Route::post('InscriKaraoke/','App\Http\Controllers\karaokeController@register')->name('filleinscrip');
Route::get('login/', 'App\Http\Controllers\karaokeController@show')->name('login');
Route::get('/check-phone-number/{phoneNumber}', 'KaraokeController@checkPhoneNumber');

//auth
Route::post('/login', 'App\Http\Controllers\karaokeController@loginUser')->name('login');

Route::post('/karaoke/update-name/{id}','App\Http\Controllers\karaokeController@updateName')->name('update_name');
    Route::post('/karaoke/update-numero/{id}', 'App\Http\Controllers\karaokeController@updateNumero')->name('update_numero');
    Route::post('/karaoke/update-pseudo/{id}', 'App\Http\Controllers\karaokeController@updatPseudo')->name('update_pseudo');
//profile view



Route::get('/Karaokeprofils/{userId}', 'App\Http\Controllers\karaokeController@showKaraokeProfile')->name('Karaokeprofils');
/* A D M I N */


Route::get('admin', function () {
    return view('Admin/login');
});
// Route::get('KaraokeUsers', function () {
//     return view('Admin/KaraokeUsers');
// });

// Route::get('NousUsers', function () {
//     return view('Admin/NousUsers');
// });

Route::get('KaraokeUsers', 'App\Http\Controllers\AdminController@showAllKaraokeUsers')->name('KaraokeUsers');
Route::get('NousUsers', 'App\Http\Controllers\AdminController@showAllNousUsers')->name('Noussers');


Route::get('LokKaraokeUsers', 'App\Http\Controllers\AdminController@showLokKaraokeUsers')->name('LokKaraokeUsers');
Route::get('LokNousUsers', 'App\Http\Controllers\AdminController@showLokNousUsers')->name('LokNousUsers');


Route::post('block-user/{id}', 'App\Http\Controllers\AdminController@blockUser')->name('block.user');
Route::post('/unblock/user/{id}', 'App\Http\Controllers\AdminController@unblockUser')->name('unblock.user');



Route::get('utilisateurs', 'App\Http\Controllers\AdminController@showAllUsers')->name('utilisateurs');
Route::post('/payment', 'App\Http\Controllers\karaokeController@processPayment')->name('payment.form');
