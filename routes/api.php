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
Route::middleware('auth:sanctum')->post('/uploadimage', [UserController::class, 'uploadImage'])->name('api.uploadimage');
Route::middleware('auth:sanctum')->get('/checkphotos', [UserController::class, 'checkPhotos'])->name('api.checkphotos');
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'view'])->name('api.user');
Route::get('/allusers', [UserController::class, 'all'])->name('api.allusers');


// Auth routes
Route::post('/register', [UserController::class, 'store'])->name('api.inscription.store');
Route::post('/login', [UserController::class, 'login'])->name('api.login');
Route::post('/logout', [UserController::class, 'logout'])->name('api.logout');

// User profile routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-name', [UserController::class, 'updateName'])->name('api.updateName');
    Route::post('/update-email', [UserController::class, 'updateEmail'])->name('api.updateEmail');
    Route::post('/update-pseudo', [UserController::class, 'updatePseudo'])->name('api.updatePseudo');
    Route::post('/update-numero', [UserController::class, 'updateNumero'])->name('api.updateNumero');
    Route::post('/update-town', [UserController::class, 'updateTown'])->name('api.updateTown');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('api.updatePassword');
    Route::post('/update-looking-for', [UserController::class, 'updateLookingFor'])->name('api.updateLookingFor');
    Route::post('/update-genre', [UserController::class, 'updateGenre'])->name('api.updateGenre');
    Route::post('/update-mariatal-status', [UserController::class, 'updateMariatalStatus'])->name('api.updateMariatalStatus');
    Route::post('/update-about', [UserController::class, 'updateAbout'])->name('api.updateAbout');

});

Route::middleware('auth:sanctum')->post('/updatephotos', [UserController::class, 'updatePhotos'])->name('api.updatePhotos');

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
