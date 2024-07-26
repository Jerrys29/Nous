<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\KaraokeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NousController;

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



////Karaokee


// Espace Karaoke
Route::get('/kprofil', [KaraokeController::class, 'showprofil'])->name('api.kprofil');
Route::post('/update-profile', [KaraokeController::class, 'updateProfile'])->name('api.update-profile');
Route::get('/index', [KaraokeController::class, 'showAllKaraokeProfiles'])->name('api.karaokeusers');
Route::post('/inscription', [KaraokeController::class, 'register'])->name('api.filleinscrip');
Route::get('/connection', [KaraokeController::class, 'show'])->name('api.connection');
Route::get('/check-phone-number/{phoneNumber}', [KaraokeController::class, 'checkPhoneNumber']);
Route::post('/connection', [KaraokeController::class, 'loginUser'])->name('api.logins');
Route::post('/karaoke/update-name/{id}', [KaraokeController::class, 'updateName'])->name('api.update_name');
Route::post('/karaoke/update-numero/{id}', [KaraokeController::class, 'updateNumero'])->name('api.update_numero');
Route::post('/karaoke/update-pseudo/{id}', [KaraokeController::class, 'updatePseudo'])->name('api.update_pseudo');
Route::post('/visiteurs/{id}', [KaraokeController::class, 'Visiteurs'])->name('api.paiementV');
Route::post('/karaoke/update-town/{id}', [KaraokeController::class, 'updateTown'])->name('api.update-town');
Route::get('/Karaokeprofils/{userId}', [KaraokeController::class, 'showKaraokeProfile'])->name('api.Karaokeprofils');
Route::post('/payment', [KaraokeController::class, 'processPayment'])->name('api.payment.form');
Route::post('/deconnexion', [KaraokeController::class, 'Deco'])->name('api.deconnexion');
Route::get('/deconnexion', [AdminController::class, 'Deco'])->name('api.Deco');
Route::get('/upload-photos/{userId}', [KaraokeController::class, 'showPhotoUploadForm'])->name('api.upload.photo');
Route::post('/store-photos', [KaraokeController::class, 'storePhotos'])->name('api.storePhotos');

// Admin routes
Route::get('/visiteur/{id}', [KaraokeController::class, 'visiteur'])->name('api.visiteur');
Route::get('/KaraokeUsers', [AdminController::class, 'showAllKaraokeUsers'])->name('api.KaraokeUsers');
Route::get('/NousUsers', [AdminController::class, 'showAllNousUsers'])->name('api.NousUsers');
Route::get('/LokKaraokeUsers', [AdminController::class, 'showLokKaraokeUsers'])->name('api.LokKaraokeUsers');
Route::get('/LokNousUsers', [AdminController::class, 'showLokNousUsers'])->name('api.LokNousUsers');
Route::get('/avisadmin', [AdminController::class, 'showavis'])->name('api.avisadmin');
Route::post('/block/user/{id}/{redirect}', [AdminController::class, 'blockUser'])->name('api.block.user');
Route::post('/unblock/user/{id}/{redirect}', [AdminController::class, 'unblockUser'])->name('api.unblock.user');
Route::post('/blockNousUser/user/{id}/{redirect}', [AdminController::class, 'blockNousUser'])->name('api.blockNous.User');
Route::post('/unblockNousUser/user/{id}/{redirect}', [AdminController::class, 'unblockNousUser'])->name('api.unblockNous.User');
Route::post('/delete/user/{id}/{redirect}', [AdminController::class, 'deleteUser'])->name('api.delete.user');
Route::get('/utilisateurs', [AdminController::class, 'showAllUsers'])->name('api.utilisateurs');
Route::get('/publicites/list', [AdminController::class, 'index'])->name('api.publicites');
Route::get('/publicites/{id}/view', [AdminController::class, 'detailspub'])->name('api.publicites.details');
Route::post('/publicites/create', [AdminController::class, 'storepub'])->name('api.publicites.create');
Route::get('/publicites/create', [AdminController::class, 'createpub'])->name('api.publicite.create.view');
Route::get('/publicites/{id}/edit', [AdminController::class, 'editpub'])->name('api.publicites.edit');
Route::post('/publicites/{id}/activate', [AdminController::class, 'toggleStatuspub'])->name('api.publicites.toggle');
Route::post('/publicites/{id}/update', [AdminController::class, 'updatepub'])->name('api.publicites.update');
Route::get('/publicite/details', [AdminController::class, 'showpub'])->name('api.detailspub');
Route::get('/publicites/search', [AdminController::class, 'search'])->name('api.searchpub');


// Forget password routes

Route::get('/number', [ForgetPasswordController::class, 'forgetpassword'])->name('api.mdp');
Route::get('/checknumber', [ForgetPasswordController::class, 'checknumber'])->name('api.check');
Route::get('/quiz/{numero}', [ForgetPasswordController::class, 'showQuiz'])->name('api.quiz.show');
Route::post('/verify-information', [ForgetPasswordController::class, 'verifyInformation'])->name('api.verify.information');
Route::get('/password/reset/{id}', [ForgetPasswordController::class, 'showResetForm'])->name('api.password.reset');
Route::post('/password/reset', [ForgetPasswordController::class, 'resetPassword'])->name('api.password.update');


// Avis routes
Route::get('/avis', [NousController::class, 'avisshow'])->name('api.avis');
Route::post('/avis', [NousController::class, 'avis'])->name('api.avis.save');