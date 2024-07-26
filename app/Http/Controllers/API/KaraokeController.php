<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paiements;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
            return response()->json(['error' => 'Impossible d\'utiliser ce numéro pour vous inscrire. Veuillez utiliser un autre numéro.'], 400);
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

        return response()->json(['success' => 'Ajoutez deux photos pour finaliser votre inscription.', 'user' => $user], 201);
    }

    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user]);
    }

    public function checkPhoneNumber($phoneNumber)
    {
        $exists = User::where('numero', $phoneNumber)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('numero', 'password');
        $credentials['numero'] = preg_replace('/\s+/', '', $credentials['numero']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->active == 1) {
                $token = $user->createToken('API Token')->plainTextToken; // Assurez-vous d'utiliser Sanctum ou Passport pour les tokens API
                return response()->json(['token' => $token, 'user' => $user]);
            } else {
                return response()->json(['error' => 'Votre compte n\'est pas actif. Veuillez revenir dans quelques heures.'], 403);
            }
        } else {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }
    }

    public function showProfil(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user]);
    }

    public function updateName(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        $user->update($validatedData);

        return response()->json(['success' => 'Nom mis à jour avec succès.']);
    }

    public function updateNumero(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        $user->update($validatedData);

        return response()->json(['success' => 'Numéro mis à jour avec succès.']);
    }

    public function updatetown(Request $request, $id)
    {
        $validatedData = $request->validate([
            'town' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        $user->update($validatedData);

        return response()->json(['success' => 'Ville mise à jour avec succès.']);
    }

    public function updatePseudo(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pseudo' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        $user->update($validatedData);

        return response()->json(['success' => 'Pseudo mis à jour avec succès.']);
    }

    public function showAllKaraokeProfiles()
    {
        $users = User::where('role', 'karaoke')
                    ->where('active', 1)
                    ->get();
        
        return response()->json(['users' => $users]);
    }

    public function showKaraokeProfile($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json(['user' => $user]);
    }

    public function deco(Request $request)
    {
        Auth::logout();
        return response()->json(['success' => 'Déconnexion réussie.']);
    }

    public function processPayment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        $userId = auth()->check() ? auth()->id() : 0;

        $payment = Paiements::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
        ]);

        return response()->json(['success' => 'Paiement traité avec succès.']);
    }

    public function visiteur($userId)
    {
        return response()->json(['userId' => $userId]);
    }

    public function visiteurs(Request $request, $userId)
    {
        $request->validate([
            'name' => 'required|string',
            'numero' => [
                'required',
                'string',
            ],
        ]);

        $cleanedNumero = preg_replace('/\s+/', '', $request->input('numero'));

        $user = User::findOrFail($userId);

        $newUser = User::create([
            'name' => $request->input('name'),
            'numero' => $cleanedNumero,
            'role' => 'visiteur',
        ]);

        return response()->json(['user' => $newUser, 'userPhoneNumber' => $user->numero]);
    }

    public function showPhotoUploadForm($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json(['user' => $user]);
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

        return response()->json(['success' => 'Photos ajoutées avec succès.']);
    }
}
