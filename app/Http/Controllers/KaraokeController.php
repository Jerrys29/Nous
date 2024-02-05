<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paiements;
use Illuminate\Support\Facades\Hash; // Assurez-vous d'importer la classe Hash
use Illuminate\Validation\Rule; // Assurez-vous d'importer la classe Rule pour la validation

class KaraokeController extends Controller
{
    public function register(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'numero' => [
                'required',
                'string',
                Rule::unique('users', 'numero'), // Vérifie si le numéro est unique dans la table users
            ],
            'pseudo' => 'required|string',
            'birthdate' => 'required|date',
            'birthplace' => 'required|string',
            'origin_country' => 'required|string',
        ]);
    
        // Nettoyez le numéro en supprimant les espaces en trop
        $cleanedNumero = preg_replace('/\s+/', '', $request->input('numero'));
    
        if (User::where('numero', $cleanedNumero)->exists()) {
            $errorMessage = 'Impossible d\'utiliser ce numéro pour vous inscrire. Veuillez utiliser un autre numéro.';
            return redirect()->route('inscription')->withErrors(['customError' => $errorMessage]);
        }
    
        // Utilisez la fonction Hash::make pour hacher le mot de passe avant de l'enregistrer dans la base de données
        $hashedPassword = Hash::make($request->input('password'));
    
        // Créez un nouvel utilisateur avec le rôle 'karaoke' et les données du formulaire
        $user = User::create([
            'name' => $request->input('name'),
            'password' => $hashedPassword,
            'numero' => $cleanedNumero, // Utilisez le numéro nettoyé
            'pseudo' => $request->input('pseudo'),
            'birthdate' => $request->input('birthdate'),
            'birthplace' => $request->input('birthplace'),
            'origin_country' => $request->input('origin_country'),
            'role' => 'karaoke',
        ]);
    
        // Redirigez ou effectuez d'autres actions après l'enregistrement
    
        return redirect()->route('connection')->with('success', 'Félicitation !! Votre compte sera activé dans les plus brefs délais. Revenez dans 24h.');
    }
    

    public function show()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        return view('karaoke/connection', compact('user'));
    }

    public function showRegistration()
    {
        return view('karaoke/InscriKaraoke');
    }

    public function checkPhoneNumber($phoneNumber)
    {
        // Effectuez la vérification du numéro de téléphone
        $exists = User::where('numero', $phoneNumber)->exists();

        // Retournez une réponse JSON
        return response()->json(['exists' => $exists]);
    }

//connection utilisateur

    public function loginUser(Request $request)
    {
        $credentials = $request->only('numero', 'password');
        $credentials['numero'] = preg_replace('/\s+/', '', $credentials['numero']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->active == 1) {
                // gérer les différents rôles et rediriger en conséquence
                if ($user->role == 'karaoke') {
                    $request->session()->regenerate();
                    return redirect()->route('kprofil');
                } elseif ($user->role == 'admin') {
                    $request->session()->regenerate();
                    return redirect()->route('utilisateurs'); // Redirigez vers la page admin si le rôle est admin
                } else {
                    // Redirigez vers la page de connexion avec un message d'erreur
                    auth()->logout();
                    return redirect()->route('connection')->withErrors(['credentials' => 'Erreur de connexion.'])->withInput();
                }
            } else {
                // Si le champ 'active' n'est pas égal à 1, l'utilisateur n'est pas autorisé
                auth()->logout();
                return redirect()->route('connection')->withErrors(['active' => 'Votre compte n\'est pas actif. Veuillez revenir dans quelques heures.'])->withInput();
            }
        } else {
            // Si l'authentification échoue, redirigez avec des erreurs
            return redirect()->route('connection')->withErrors(['credentials' => 'Identifiants invalides'])->withInput();
        }
    }

public function showprofil()
    { 
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        return view('karaoke/profilperso',compact('user'));
    }


    public function showUserProfile() {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // L'utilisateur est connecté, vous pouvez maintenant utiliser $user pour accéder à ses propriétés
            return view('profilperso',  compact('user'));
        } else {
            // Rediriger ou afficher un message d'erreur si l'utilisateur n'est pas connecté
            return redirect('/connection')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
    }

    public function updateName(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        $user->update($validatedData);

        return redirect()->back()->with('success', 'Nom mis à jour avec succès.');
    }

    public function updateNumero(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        $user->update($validatedData);

        return redirect()->back()->with('success', 'Numéro mis à jour avec succès.');
    }

    public function updatePseudo(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pseudo' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        $user->update($validatedData);

        return redirect()->back()->with('success', 'Pseudo mis à jour avec succès.');
    }

    public function showAllKaraokeProfiles()
    {
        // Récupérer tous les utilisateurs ayant le rôle "karaoke" et dont le compte est activé
        // avec au moins un profil et au moins une photo associée
        $users = User::where('role', 'karaoke')
                    ->where('active', 1)
                    ->where(function ($query) {
                        // Vérifier s'il y a au moins une photo non nulle
                        $query->whereNotNull('photo1')
                              ->orWhereNotNull('photo2')
                              ->orWhereNotNull('photo3')
                              ->orWhereNotNull('photo4')
                              ->orWhereNotNull('photo5');
                    })
                    ->get();
        
        // Passer les données à la vue
        return view('karaoke.index', compact('users'));
    }
    
    
    
        // KaraokeController.php
        public function showKaraokeProfile($userId)
        {
            $user = User::findOrFail($userId);
        
            // Afficher la vue même si toutes les colonnes de photos sont null
            return view('karaoke/profilevue', ['user' => $user]);
        }
        

        


public function processPayment(Request $request)
{
    // Validez les données du formulaire de paiement
    $request->validate([
        'name' => 'required|string',
        'phone' => 'required|numeric',
    ]);

    // Créez une nouvelle entrée dans la table des paiements
    $payment = Paiements::create([
        'user_id' => auth()->id(), // L'ID de l'utilisateur connecté
        'payee_name' => $request->input('name'),
        'payee_phone' => $request->input('phone'),
    ]);

    // Vous pouvez également faire d'autres actions ici, telles que rediriger l'utilisateur ou afficher un message de succès.

    return redirect()->back()->with('success', 'Paiement enregistré avec succès.');
}
    
        public function Deco()
        {
            Auth::logout();

            return redirect('/connection');
        }

}
