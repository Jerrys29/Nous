<?php

use App\Http\Controllers\NousController;
use Illuminate\Support\Facades\Route;

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

Route::get('profils', function () {
    return view('Nous/profils');
});

Route::get('register', function () {
    return view('Nous/register');
});
Route::get('terms', function () {
    return view('Nous/terms');
});
Route::get('/', 'App\Http\Controllers\NousController@index')->name('index');
Route::get('/edit', 'App\Http\Controllers\NousController@edit')->name('edit');
Route::post('/register', 'App\Http\Controllers\NousController@store')->name('inscription.store');
Route::get('/login', 'App\Http\Controllers\NousController@loginview')->name('login');
Route::post('/login', 'App\Http\Controllers\NousController@login')->name('login');
Route::get('/profils', 'App\Http\Controllers\NousController@view')->name('profils');
Route::get('/profil/{userId}', 'App\Http\Controllers\NousController@detail')->name('profil');
Route::put('/profile/update', 'App\Http\Controllers\NousController@update')->name('profile.update');
Route::post('/profile/photos/update', 'App\Http\Controllers\NousController@updatePhotos')->name('profile.photos.update');

Route::put('/update-name/{id}', 'App\Http\Controllers\NousController@updatename')->name('update-name');
Route::put('/update-numero/{id}', 'App\Http\Controllers\NousController@updatenumero')->name('update-numero');
Route::put('/update-password/{id}', 'App\Http\Controllers\NousController@updatepassword')->name('update-password');
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
Route::post('/chat/send', 'App\Http\Controllers\ChatController@sendMessage')->name('chat.send');
Route::post('/discussion', 'App\Http\Controllers\ChatController@store')->name('discussion.store');


Route::get('/messages', 'App\Http\Controllers\ChatController@view')->name('messages');
Route::get('/detail', 'App\Http\Controllers\ChatController@detail')->name('detail');









/*E S P A C E K A R A O K E */



Route::get('kprofil', 'App\Http\Controllers\KaraokeController@showprofil')->name('kprofil');




// Route::get('karaoke', function () {
//     return view('Karaoke/index');
// });

Route::get('inscription', function () {
    return view('Karaoke/InscriKaraoke');
});
// Route::get('connection', function () {
//     return view('Karaoke/login')->name('connection');;
// });
Route::get('formulaire', function () {
    return view('Karaoke/formulaire');
});
Route::get('/inscription', 'App\Http\Controllers\KaraokeController@showRegistration')->name('inscription');
// web.php


   


//route vers mise à jour du profil
Route::post('/update-profile', 'App\Http\Controllers\KaraokeController@updateProfile')->name('update-profile');


//page index
// Ajoutez cette ligne dans votre fichier web.php
Route::get('/index', 'App\Http\Controllers\KaraokeController@showAllKaraokeProfiles')->name('karaokeusers');



Route::post('InscriKaraoke/','App\Http\Controllers\KaraokeController@register')->name('filleinscrip');
Route::get('connection/', 'App\Http\Controllers\KaraokeController@show')->name('connection');
Route::get('/check-phone-number/{phoneNumber}', 'KaraokeController@checkPhoneNumber');

//auth
 Route::post('/connection', 'App\Http\Controllers\KaraokeController@loginUser')->name('logins');

Route::post('/karaoke/update-name/{id}','App\Http\Controllers\KaraokeController@updateName')->name('update_name');
Route::post('/karaoke/update-numero/{id}', 'App\Http\Controllers\KaraokeController@updateNumero')->name('update_numero');
Route::post('/karaoke/update-pseudo/{id}', 'App\Http\Controllers\KaraokeController@updatPseudo')->name('update_pseudo');
Route::post('/visiteurs/{id}','App\Http\Controllers\KaraokeController@Visiteurs')->name('paiementV');


//profile view



Route::get('/Karaokeprofils/{userId}', 'App\Http\Controllers\KaraokeController@showKaraokeProfile')->name('Karaokeprofils');
/* A D M I N */

Route::get('/visiteur/{id}', 'App\Http\Controllers\KaraokeController@visiteur')->name('visiteur');

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
Route::post('/payment', 'App\Http\Controllers\KaraokeController@processPayment')->name('payment.form');
Route::post('/deconnexion', 'App\Http\Controllers\KaraokeController@Deco')->name('deconnexion');
Route::get('/deconnexion', 'App\Http\Controllers\AdminController@Deco')->name('Deco');