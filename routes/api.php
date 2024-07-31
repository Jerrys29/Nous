<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\API\KaraokeController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\NousController;
use App\Http\Controllers\API\ForgetPasswordController;

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

// Karaoke routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('kprofil', 'App\Http\Controllers\KaraokeController@showprofil')->name('api.kprofil');

    Route::post('/update-profile', 'App\Http\Controllers\KaraokeController@updateProfile')->name('api.update-profile');
    Route::get('/index', 'App\Http\Controllers\KaraokeController@showAllKaraokeProfiles')->name('api.karaokeusers');

    Route::post('InscriKaraoke', 'App\Http\Controllers\KaraokeController@register')->name('api.filleinscrip');
    Route::post('/karaoke/update-name/{id}', 'App\Http\Controllers\KaraokeController@updateName')->name('api.update_name');
    Route::post('/karaoke/update-numero/{id}', 'App\Http\Controllers\KaraokeController@updateNumero')->name('api.update_numero');
    Route::post('/karaoke/update-pseudo/{id}', 'App\Http\Controllers\KaraokeController@updatPseudo')->name('api.update_pseudo');
    Route::post('/visiteurs/{id}', 'App\Http\Controllers\KaraokeController@Visiteurs')->name('api.paiementV');
    Route::post('/karaoke/update-town/{id}', 'App\Http\Controllers\KaraokeController@updatetown')->name('api.update-town');

    Route::get('/Karaokeprofils/{userId}', 'App\Http\Controllers\KaraokeController@showKaraokeProfile')->name('api.Karaokeprofils');

    Route::post('block/user/{id}/{redirect}', 'App\Http\Controllers\AdminController@blockUser')->name('api.block.user');
    Route::post('/unblock/user/{id}/{redirect}', 'App\Http\Controllers\AdminController@unblockUser')->name('api.unblock.user');
    Route::post('blockNousUser/user/{id}/{redirect}', 'App\Http\Controllers\AdminController@blockNousUser')->name('api.blockNous.User');
    Route::post('/unblockNousUser/user/{id}/{redirect}', 'App\Http\Controllers\AdminController@unblockNousUser')->name('api.unblockNous.User');
    Route::post('/delete/user/{id}/{redirect}', 'App\Http\Controllers\AdminController@deleteUser')->name('api.delete.user');

    Route::post('/payment', 'App\Http\Controllers\KaraokeController@processPayment')->name('api.payment.form');
    Route::post('/deconnexion', 'App\Http\Controllers\KaraokeController@Deco')->name('api.deconnexion');
    Route::get('/deconnexion', 'App\Http\Controllers\AdminController@Deco')->name('api.Deco');

    Route::post('avis', 'App\Http\Controllers\NousController@avis')->name('api.avis.save');
    Route::get('avis', 'App\Http\Controllers\NousController@avisshow')->name('api.avis');

    Route::get('publicites/list', 'App\Http\Controllers\AdminController@index')->name('api.publicites');
    Route::get('publicites/{id}/view', 'App\Http\Controllers\AdminController@detailspub')->name('api.publicites.details');
    Route::post('publicites/create', 'App\Http\Controllers\AdminController@storepub')->name('api.publicites.create');
    Route::get('publicites/create', 'App\Http\Controllers\AdminController@createpub')->name('api.publicite.create.view');
    Route::get('publicites/{id}/edit', 'App\Http\Controllers\AdminController@editpub')->name('api.publicites.edit');
    Route::post('publicites/{id}/activate', 'App\Http\Controllers\AdminController@toggleStatuspub')->name('api.publicites.toggle');
    Route::post('publicites/{id}/update', 'App\Http\Controllers\AdminController@updatepub')->name('api.publicites.update');
    Route::get('publicite/details', 'App\Http\Controllers\AdminController@showpub')->name('api.detailspub');
    Route::get('publicites/search', 'App\Http\Controllers\AdminController@search')->name('api.searchpub');

    Route::get('/number', 'App\Http\Controllers\ForgetPasswordController@forgetpassword')->name('api.mdp');
    Route::get('/checknumber', 'App\Http\Controllers\ForgetPasswordController@checknumber')->name('api.check');
    Route::get('/quiz/{numero}', 'App\Http\Controllers\ForgetPasswordController@showQuiz')->name('api.quiz.show');
    Route::post('/verify-information',  'App\Http\Controllers\ForgetPasswordController@verifyInformation')->name('api.verify.information');
    Route::get('/password/reset/{id}',  'App\Http\Controllers\ForgetPasswordController@showResetForm')->name('api.password.reset');
    Route::post('/password/reset', 'App\Http\Controllers\ForgetPasswordController@resetPassword')->name('api.password.update');

    Route::get('/upload-photos/{userId}', 'App\Http\Controllers\KaraokeController@showPhotoUploadForm')->name('api.upload.photo');
    Route::post('/store-photos', 'App\Http\Controllers\KaraokeController@storePhotos')->name('api.storePhotos');
});

// Authentification publique
Route::post('/connection', 'App\Http\Controllers\KaraokeController@loginUser')->name('api.logins');
Route::get('/check-phone-number/{phoneNumber}', 'App\Http\Controllers\KaraokeController@checkPhoneNumber');
Route::post('InscriKaraoke', 'App\Http\Controllers\KaraokeController@register')->name('api.filleinscrip');

// Routes d'administration
Route::get('admin', function () {
    return response()->json(['message' => 'Admin login view']);
});
Route::get('KaraokeUsers', 'App\Http\Controllers\AdminController@showAllKaraokeUsers')->name('api.KaraokeUsers');
Route::get('NousUsers', 'App\Http\Controllers\AdminController@showAllNousUsers')->name('api.NousUsers');
Route::get('LokKaraokeUsers', 'App\Http\Controllers\AdminController@showLokKaraokeUsers')->name('api.LokKaraokeUsers');
Route::get('LokNousUsers', 'App\Http\Controllers\AdminController@showLokNousUsers')->name('api.LokNousUsers');
Route::get('avisadmin', 'App\Http\Controllers\AdminController@showavis')->name('api.avisadmin');
Route::get('utilisateurs', 'App\Http\Controllers\AdminController@showAllUsers')->name('api.utilisateurs');