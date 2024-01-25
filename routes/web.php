<?php

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
    return view('Karaoke/profils');
});
Route::get('detailprofil', function () {
    return view('Karaoke/detail');
});
Route::get('inscription', function () {
    return view('Karaoke/register');
});
Route::get('formulaire', function () {
    return view('Karaoke/formulaire');
});


/* A D M I N */


Route::get('admin', function () {
    return view('Admin/login');
});
Route::get('utilisateurs', function () {
    return view('Admin/users');
});

