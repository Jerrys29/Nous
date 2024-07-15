<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ChatController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [UserController::class, 'store'])->name('api.inscription.store');
Route::post('/login', [UserController::class, 'login'])->name('api.login');
Route::post('/logout', [UserController::class, 'logout'])->name('api.logout');

// User profile routes
Route::get('/user', [UserController::class, 'view'])->name('api.user')->middleware('auth:sanctum');
Route::get('/profile/{userId}', [UserController::class, 'detail'])->name('api.profile')->middleware('auth:sanctum');
Route::put('/profile/update', [UserController::class, 'update'])->name('api.profile.update')->middleware('auth:sanctum');
Route::post('/profile/photos/update', [UserController::class, 'updatePhotos'])->name('api.profile.photos.update')->middleware('auth:sanctum');

// Update profile details routes
Route::put('/update-name/{id}', [UserController::class, 'updatename'])->name('api.update-name')->middleware('auth:sanctum');
Route::put('/update-numero/{id}', [UserController::class, 'updatenumero'])->name('api.update-numero')->middleware('auth:sanctum');
Route::put('/update-password/{id}', [UserController::class, 'updatepassword'])->name('api.update-password')->middleware('auth:sanctum');
Route::put('/update-pseudo/{id}', [UserController::class, 'updatepseudo'])->name('api.update-pseudo')->middleware('auth:sanctum');
Route::put('/update-age/{id}', [UserController::class, 'updateage'])->name('api.update-age')->middleware('auth:sanctum');
Route::put('/update-about/{id}', [UserController::class, 'updateabout'])->name('api.update-about')->middleware('auth:sanctum');
Route::put('/update-interests/{id}', [UserController::class, 'updateinterests'])->name('api.update-interests')->middleware('auth:sanctum');

// Store images routes
Route::post('/store-images1', [UserController::class, 'storephoto1'])->name('api.store-images1')->middleware('auth:sanctum');
Route::post('/store-images2', [UserController::class, 'storephoto2'])->name('api.store-images2')->middleware('auth:sanctum');
Route::post('/store-images3', [UserController::class, 'storephoto3'])->name('api.store-images3')->middleware('auth:sanctum');
Route::post('/store-images4', [UserController::class, 'storephoto4'])->name('api.store-images4')->middleware('auth:sanctum');
Route::post('/store-images5', [UserController::class, 'storephoto5'])->name('api.store-images5')->middleware('auth:sanctum');
Route::post('/store-images6', [UserController::class, 'storephoto6'])->name('api.store-images6')->middleware('auth:sanctum');

// Notification routes
Route::get('/notification', [UserController::class, 'showNotifications'])->name('api.notification')->middleware('auth:sanctum');

// Like/Unlike profile routes
Route::post('/like-profile/{profile_id}', [UserController::class, 'likeProfile'])->name('api.like-profile')->middleware('auth:sanctum');
Route::post('/unlike-profile/{profile_id}', [UserController::class, 'unlikeProfile'])->name('api.unlike-profile')->middleware('auth:sanctum');

// Payment update route
Route::get('/mettre-a-jour-paiement', [UserController::class, 'mettreAJourPaiement'])->middleware('auth:sanctum');

// Chat routes
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('api.chat.send')->middleware('auth:sanctum');
Route::post('/discussion', [ChatController::class, 'store'])->name('api.discussion.store')->middleware('auth:sanctum');
Route::post('/envoi', [ChatController::class, 'send'])->name('api.discussion.send')->middleware('auth:sanctum');
Route::get('/get-new-messages/{lastMessageId}', [ChatController::class, 'getNewMessages'])->name('api.getNewMessages')->middleware('auth:sanctum');
Route::post('/envoyerMessage', [ChatController::class, 'envoyerMessage'])->name('api.envoyerMessage')->middleware('auth:sanctum');
Route::get('/messages', [ChatController::class, 'view'])->name('api.messages')->middleware('auth:sanctum');
Route::get('/detail/{namesender}/{numero}', [ChatController::class, 'viewDetail'])->name('api.detail')->middleware('auth:sanctum');

// Search route
Route::get('/search', [UserController::class, 'search'])->name('api.search')->middleware('auth:sanctum');
