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
            Rule::unique('users', 'numero'),
        ],
        'pseudo' => 'required|string',
        'birthdate' => 'required|date',
        'birthplace' => 'required|string',
        'town' => 'required|string',
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
        'numero' => $cleanedNumero,
        'pseudo' => $request->input('pseudo'),
        'birthdate' => $request->input('birthdate'),
        'birthplace' => $request->input('birthplace'),
        'town' => $request->input('town'),
        'role' => 'karaoke',
    ]);

    // Redirigez vers la page de téléchargement de photo
    return redirect()->route('upload.photo', ['userId' => $user->id])->with('success', 'Ajoutez deux photos pour finaliser votre inscription.');

    }

    

    public function show()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        return view('Karaoke/connection', compact('user'));
    }

    public function showRegistration()
    {
        return view('Karaoke/InscriKaraoke');
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

        return view('Karaoke/profilperso',compact('user'));
    }


    public function showUserProfile() {
        // Récupérer l'utilisateur connecté:
        $user = Auth::user();
    
        // Vérifier si l'utilisateur est connecté
        if ($user->role == 'karaoke' && $user->activity == 1) {
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

    public function updatetown(Request $request, $id)
    {
        $validatedData = $request->validate([
            'town' => 'required|string',
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
        // avec au moins un profil
        $users = User::where('role', 'karaoke')
                    ->where('active', 1)
                    ->get();
        
        // Passer les données à la vue
        return view('Karaoke.index', compact('users'));
    }
    
    
    
    
        // KaraokeController.php
        public function showKaraokeProfile($userId)
        {
            $user = User::findOrFail($userId);
        
            // Afficher la vue même si toutes les colonnes de photos sont null
            return view('Karaoke/profilevue', ['user' => $user]);
        }
        

        

        public function Deco()
        {
            Auth::logout();

            return redirect('/connection');
        }

        public function processPayment(Request $request)
        {
            // Valider les données du formulaire de paiement
            $validatedData = $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
            ]);
    
            // Vérifier si l'utilisateur est connecté
            if (auth()->check()) {
                // Si l'utilisateur est connecté, enregistrez l'ID de l'utilisateur dans le paiement
                $userId = auth()->id();
            } else {
                // Si l'utilisateur n'est pas connecté, enregistrez l'ID de l'utilisateur en tant qu'invité (par exemple, 0)
                $userId = 0;
            }
    
            // Créer une nouvelle entrée dans la table des paiements
            $payment = Paiements::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                
            ]);
    
            // Autres actions après le traitement du paiement
            // Rediriger l'utilisateur vers la page detail.blade ou effectuer d'autres actions
    
            return redirect()->route('Karaokeprofils')->with('success', 'Payez un forfait pour communiquer par WhatsApp');
        }
    
        
    
        public function visiteur($userId)
        {
            $user = User::find($userId);

            return view('Karaoke/formulaire', ['userId' => $userId]);
        }


        public function Visiteurs(Request $request, $userId)
        {
            // Validez les données du formulaire
            $request->validate([
                'name' => 'required|string',
                'numero' => [
                    'required',
                    'string',
                ],
            ]);
        
            // Nettoyez le numéro en supprimant les espaces en trop
            $cleanedNumero = preg_replace('/\s+/', '', $request->input('numero'));
        
            // Recherchez l'utilisateur associé à l'ID
            $user = User::findOrFail($userId);
        
            // Récupérez le numéro de téléphone de l'utilisateur associé à l'ID
            $userPhoneNumber = $user->numero;
        
            // Créez un nouvel utilisateur avec le rôle 'karaoke' et les données du formulaire
            $newUser = User::create([
                'name' => $request->input('name'),
                'numero' => $cleanedNumero, // Utilisez le numéro nettoyé
                'role' => 'visiteur',
            ]);
        
            // Redirigez ou effectuez d'autres actions après l'enregistrement
            // Passez le numéro de téléphone de l'utilisateur à la vue
            return view('Karaoke/modal', ['user' => $newUser, 'userPhoneNumber' => $userPhoneNumber]);
        }
        
       

     
    public function showPhotoUploadForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('Karaoke.uploadphotos', ['user' => $user]);
    }
    
    public function storePhotos(Request $request)
    {
        $user = User::find($request->user_id);
    
        for ($i = 1; $i <= 2; $i++) {
            $photoKey = 'photo' . $i;
            if ($request->hasFile($photoKey)) {
                $imagePath = $request->file($photoKey)->store('photos', 'public');
                $user->{$photoKey} = $imagePath;
            }
        }
    
        $user->save();
    
        return redirect()->route('connection')->with('success', 'Félicitation !! Votre compte sera activé dans les plus brefs délais. Revenez dans 24h.');
    }
    
}
