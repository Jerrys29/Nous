<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
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

        if (User::where('numero', $request->input('numero'))->exists()) {
            $errorMessage = 'Impossible d\'utiliser ce numéro pour vous inscrire. Veuillez utiliser un autre numéro.';
            return redirect()->route('inscription')->withErrors(['customError' => $errorMessage]);
        }


         
   

        // Utilisez la fonction Hash::make pour hacher le mot de passe avant de l'enregistrer dans la base de données
        $hashedPassword = Hash::make($request->input('password'));

        // Créez un nouvel utilisateur avec le rôle 'karaoke' et les données du formulaire
        $user = User::create([
            'name' => $request->input('name'),
            'password' => $hashedPassword,
            'numero' => $request->input('numero'),
            'pseudo' => $request->input('pseudo'),
            'birthdate' => $request->input('birthdate'),
            'birthplace' => $request->input('birthplace'),
            'origin_country' => $request->input('origin_country'),
            'role' => 'karaoke',
        ]);

        // Redirigez ou effectuez d'autres actions après l'enregistrement

        return redirect()->route('login')->with('success', 'Félicitation !! Votre compte sera activé dans les plus brefs délais. Revenez dans 24h.');
    }

    public function show()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        return view('karaoke/login', compact('user'));
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
            return redirect('/login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
    }

    public function updateProfile(Request $request)
{
    // Validez les données du formulaire, assurez-vous d'ajouter des règles de validation appropriées
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'pseudo' => 'required|string|max:255',
        'birthdate' => 'nullable|date',
        'birthplace' => 'nullable|string|max:255',
        'origin_country' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
    ]);

    // Mettez à jour les informations de l'utilisateur
    $user = Auth::user();
    /** @var \App\Models\User $user **/
    $user->update($validatedData);

    // Redirigez l'utilisateur vers la page du profil ou une autre page appropriée
    return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès!');
}


    

}
