<?php

use App\Http\Controllers\NousController;
use Illuminate\Support\Facades\Auth;
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

// webhook
// routes/web.php

Route::get('/mettre-a-jour-paiement','App\Http\Controllers\NousController@mettreAJourPaiement');

/*E S P A C E K A R A O K E */


Route::get('karaoke', function () {
    return view('Karaoke/index');
});
Route::get('profil', function () {
    return view('Karaoke/profilperso');
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

Route::middleware(['auth'])->group(function () {
   //route vers le profilperso
Route::get('/profil', 'App\Http\Controllers\karaokeController@showprofil')->name('profil');
});

//route vers mise à jour du profil
Route::post('/update-profile', 'App\Http\Controllers\karaokeController@updateProfile')->name('update-profile');





Route::post('InscriKaraoke/','App\Http\Controllers\karaokeController@register')->name('filleinscrip');
Route::get('login/', 'App\Http\Controllers\karaokeController@show')->name('login');
Route::get('/check-phone-number/{phoneNumber}', 'KaraokeController@checkPhoneNumber');

//auth
Route::post('/login', 'App\Http\Controllers\karaokeController@loginUser')->name('login');



/* A D M I N */


Route::get('admin', function () {
    return view('Admin/login');
});
Route::get('utilisateurs', function () {
    return view('Admin/users');
});

