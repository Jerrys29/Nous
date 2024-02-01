<?php

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

