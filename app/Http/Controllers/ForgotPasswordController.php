<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avis;
use App\Models\Publicite;
use DateTime;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View as FacadesView;


class ForgotPasswordController extends Controller
{
    // public function showLinkRequestForm()
    // {
    //     return view('Karaoke.mdpforget');
    // }

    // public function sendResetLinkEmail(Request $request)
    // {
    //     $request->validate([
    //         'phone_number' => 'required|exists:users,numero',
    //     ]);
    
    //     // Récupérer le numéro de téléphone à partir de la requête
    //     $phoneNumber = $request->phone_number;
    
    //     // Vérifier si le numéro de téléphone existe dans la base de données
    //     $user = User::where('numero', $phoneNumber)->first();
    
    //     if (!$user) {
    //         // Retourner à la page précédente avec un message d'erreur
    //         return redirect()->back()->with('error', 'Ce numéro de téléphone n\'existe pas. Veuillez créer un compte.');
    //     }
    
    //     // Générer un code à 4 chiffres
    //     $code = rand(1000, 9999);
    
    //     // Enregistrer le code dans la session de l'utilisateur
    //     $request->session()->put('password_reset_code', $code);
    
    //     // Envoyer le code par SMS
    //     // $this->sendSMS($phoneNumber, $code);
    
    //     // Passer le numéro de téléphone à la vue otp.blade.php
    //     return view('Karaoke.otp', compact('phoneNumber'));
    // }
    


}
