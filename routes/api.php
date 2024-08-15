<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\API\ApiKaraokeController;
use App\Http\Controllers\API\NousController;
use App\Http\Controllers\API\ApiForgetPasswordController;
use Laravel\Sanctum\Sanctum;
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
// Routes API avec préfixe 'api'

    // Routes authentifiées
    Route::middleware('auth:sanctum')->group(function () { 
        Route::get('kprofil', [ApiKaraokeController::class, 'showprofil'])->name('api.kprofil');
        Route::post('/update-profile', [ApiKaraokeController::class, 'updateProfile'])->name('api.update-profile');
        Route::post('/karaoke/update-name/{id}', [ApiKaraokeController::class, 'updateName'])->name('api.update_name');
        Route::post('/karaoke/update-numero/{id}', [ApiKaraokeController::class, 'updateNumero'])->name('api.update_numero');
        Route::post('/karaoke/update-pseudo/{id}', [ApiKaraokeController::class, 'updatePseudo'])->name('api.update_pseudo');
        Route::post('/karaoke/update-town/{id}', [ApiKaraokeController::class, 'updateTown'])->name('api.update-town');
        Route::post('/deconnexion', [ApiKaraokeController::class, 'Deco'])->name('api.deconnexion');
        Route::get('/upload-photos/{userId}', [ApiKaraokeController::class, 'showPhotoUploadForm'])->name('api.upload.photo');
    });
    Route::get('/Karaokeprofils/{userId}', [ApiKaraokeController::class, 'showKaraokeProfile'])->name('api.Karaokeprofils');


 
 
 
 
 
 
    // Routes publiques
    Route::post('/payment', [ApiKaraokeController::class, 'processPayment'])->name('api.payment.form');
    Route::get('/index', [ApiKaraokeController::class, 'showAllKaraokeProfiles'])->name('api.karaokeusers');
    Route::post('/InscriKaraoke', [ApiKaraokeController::class, 'register'])->name('api.filleinscrip');
    Route::post('/visiteurs/{id}', [ApiKaraokeController::class, 'Visiteurs'])->name('api.paiementV');
    Route::get('/number', [ApiForgetPasswordController::class, 'forgetpassword'])->name('api.mdp');
    Route::get('/checknumber', [ApiForgetPasswordController::class, 'checknumber'])->name('api.check');
    Route::get('/quiz/{numero}', [ApiForgetPasswordController::class, 'showQuiz'])->name('api.quiz.show');
    Route::post('/verify-information', [ApiForgetPasswordController::class, 'verifyInformation'])->name('api.verify.information');
    Route::get('/password/reset/{id}', [ApiForgetPasswordController::class, 'showResetForm'])->name('api.password.reset');
    Route::post('/password/reset', [ApiForgetPasswordController::class, 'resetPassword'])->name('api.password.update');
    Route::post('/store-photos', [ApiKaraokeController::class, 'storePhotos'])->name('api.storePhotos');
    Route::get('/check-phone-number/{phoneNumber}', [ApiKaraokeController::class, 'checkPhoneNumber']);
    Route::post('/connection', [ApiKaraokeController::class, 'loginUser'])->name('api.logins');
   

