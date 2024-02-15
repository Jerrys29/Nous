<?php

namespace App\Http\Controllers;


use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avis;

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



class AdminController extends Controller
{


        public function loginUser(Request $request)
    {
        $credentials = $request->only('numero', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->active == 1) {
                // gérer les différents rôles et rediriger en conséquence
                if ($user->role == 'karaoke') {
                    $request->session()->regenerate();
                    return redirect()->route('profil'); // 
                } else {
                    // Redirigez vers la page de connexion avec un message d'erreur
                    auth()->logout();
                    return redirect()->route('login')->withErrors(['credentials' => 'Erreur de connexion.'])->withInput();
                }
            } else {
                // Si le champ 'active' n'est pas égal à 1, l'utilisateur n'est pas autorisé
                auth()->logout();
                return redirect()->route('login')->withErrors(['active' => 'Votre compte n\'est pas actif. Veuillez revenir dans quelques heures.'])->withInput();
            }
        } else {
            // Si l'authentification échoue, redirigez avec des erreurs
            return redirect()->route('login')->withErrors(['credentials' => 'Identifiants invalides'])->withInput();
        }
    }

    // AdminController
    public function showAllUsers()
    {
        // Récupérer tous les utilisateurs
        $users  = User::where('role', 'visiteur')->get();

        // Passer les données à la vue
        return view('Admin/users', compact('users'));
    }


    public function blockUser($id, $redirect)
{
    // Récupérer l'utilisateur à bloquer
    $user = User::find($id);

    // Vérifier si l'utilisateur en question est l'administrateur lui-même
    if ($user->role === 'admin') {
        return redirect()->route($redirect)->withErrors(['error' => 'Vous ne pouvez pas bloquer l\'administrateur.']);
    }

    // Changer le statut de l'utilisateur
    $user->active = false;

    $user->save();

    // Rediriger vers la page des utilisateurs correspondante
    return redirect()->route($redirect);
}
    
public function unblockUser($id, $redirect)
{
    // Récupérer l'utilisateur à débloquer
    $user = User::find($id);

    // Vérifier si l'utilisateur en question est l'administrateur lui-même
    if ($user->role === 'admin') {
        return redirect()->route($redirect)->withErrors(['error' => 'Vous ne pouvez pas débloquer l\'administrateur.']);
    }

    // Changer le statut de l'utilisateur
    $user->active = true;
    
    // Si la colonne activated_at est nulle, mettre à jour avec la date actuelle
    if (is_null($user->activated_at)) {
        $user->activated_at = now();
    }
    
    // Sauvegarder les modifications
    $user->save();

    // Rediriger vers la page des utilisateurs correspondante
    return redirect()->route($redirect);
}

    
    // AdminController KaraokeUsers
    

    public function showAllKaraokeUsers()
    {
       
         // Récupérer tous les utilisateurs avec le rôle "karaoke"
         $users  = User::where('role', 'karaoke')->get();

        // Passer les données à la vue
        return view('Admin/KaraokeUsers', compact('users'));
    }

    public function showLokKaraokeUsers()
    {
        // Récupérer tous les utilisateurs avec le rôle "karaoke" et un compte bloqué
        $users = User::where('role', 'karaoke')->where('active', false)->get();

        // Passer les données à la vue
        return view('Admin/LokKaraokeUsers', compact('users'));
    }
    // public function showVisiteurUsers()
    // {
    //     // Récupérer tous les utilisateurs avec le rôle "karaoke" et un compte bloqué
    //     $users = User::where('role', 'visiteur')->get();

    //     // Passer les données à la vue
    //     return view('Admin/uspaie', compact('users'));
    // }

    // AdminController NousUsers
    public function showAllNousUsers()
    {
        // Récupérer tous les utilisateurs sans le rôle "karaoke"
        $users = User::where('role',  'nous')->get();

        // Passer les données à la vue
        return view('Admin/NousUsers', compact('users'));
    }

    public function showLokNousUsers()
    {
        // Récupérer tous les utilisateurs sans le rôle "karaoke" et un compte bloqué
        $users = User::where('role',  'nous')->where('active', true)->get();

        // Passer les données à la vue
        return view('Admin/LokNousUsers', compact('users'));
    }
   


    public function Deco()
    {
        Auth::logout();
    
        return redirect('/connection');
    }
     
    public function showavis()
    {
        // Récupérer tous les avis
        $avisList = Avis::all();

        // Passer les données à la vue
        return view('Admin/avis', compact('avisList'));
    }

    
}
