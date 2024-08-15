<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Paiements;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DateTime;

use Illuminate\Support\Facades\DB;

class ApiKaraokeController extends Controller
{
    public function register(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string|min:8',
            'numero' => [
                'required',
                'string',
                Rule::unique('users', 'numero'),
            ],
            'pseudo' => 'required|string',
            'birthdate' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'birthplace' => 'required|string',
            'town' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1300', // Validation pour l'image
        ]);

        // Vérification des erreurs de validation
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation échouée',
                'messages' => $validator->errors()
            ], 400);
        }

        $validatedData = $validator->validated();

        $cleanedNumero = preg_replace('/\s+/', '', $validatedData['numero']);

        // Vérification si le numéro existe déjà
        if (User::where('numero', $cleanedNumero)->exists()) {
            return response()->json(['error' => 'Ce numéro est déjà utilisé.'], 400);
        }

        // Hachage du mot de passe
        $hashedPassword = Hash::make($validatedData['password']);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'password' => $hashedPassword,
            'numero' => $cleanedNumero,
            'pseudo' => $validatedData['pseudo'],
            'birthdate' => $validatedData['birthdate'],
            'birthplace' => $validatedData['birthplace'],
            'town' => $validatedData['town'],
            'role' => 'karaoke',
        ]);

        // Gestion de l'image de profil si elle est présente
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $photoPath = $photo->store('profile_photos', 'public'); // Stockage de l'image
            $user->photo1 = $photoPath; // Sauvegarde du chemin de l'image
            $user->save(); // Mise à jour de l'utilisateur avec le chemin de l'image
        }

        // Création du token d'authentification
        $token = $user->createToken('Nous&Karaoke')->plainTextToken;

        // Retourner une réponse JSON avec succès et les informations de l'utilisateur
        return response()->json([
            'success' => 'Inscription réussie',
            'user' => $user,
            'token' => $token
        ], 201);
    }

public function loginUser(Request $request)
{
    // Validation des données d'entrée
    $request->validate([
        'numero' => 'required|string',
        'password' => 'required|string',
    ]);

    // Nettoyage du numéro pour éviter les espaces
    $credentials = $request->only('numero', 'password');
    $credentials['numero'] = preg_replace('/\s+/', '', $credentials['numero']);

    // Tentative de connexion
    if (auth()->attempt($credentials)) {
        $user = auth()->user();

        // Vérification si l'utilisateur est actif
        if ($user->active == 1) {
            // Gestion des rôles
            if ($user->role == 'karaoke' || $user->role == 'admin') {
                // Création du token d'authentification
                $token = $user->createToken('AuthToken')->plainTextToken;

                // Retourner une réponse JSON avec succès, informations utilisateur et token
                return response()->json([
                    'status' => true,
                    'user' => $user,
                    'token' => $token,
                    'message' => 'Authentification réussie'
                ], 200);
            } else {
                // Si le rôle ne correspond pas, échec de la connexion
                auth()->logout();
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur de connexion. Rôle non autorisé.'
                ], 403);
            }
        } else {
            // Si l'utilisateur n'est pas actif
            auth()->logout();
            return response()->json([
                'status' => false,
                'message' => 'Votre compte n\'est pas actif. Veuillez revenir dans quelques heures.'
            ], 403);
        }
    } else {
        // Authentification échouée
        return response()->json([
            'status' => false,
            'message' => 'Identifiants invalides'
        ], 401);
    }
}


public function showprofil()
{
    try {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié.'
            ], 401);
        }

        // Calculer l'âge de l'utilisateur
        $age = Carbon::parse($user->birthdate)->age;

        // Vérifier les champs de photos
        $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
        $hasPhoto = false;
        $presentPhotos = [];

        foreach ($photoFields as $photoField) {
            if (!is_null($user->$photoField) && !empty($user->$photoField)) {
                $hasPhoto = true;
                $presentPhotos[] = url('storage/' . $user->$photoField);
            }
        }

        return response()->json([
            'status' => true,
            'user' => $user,
            'age' => $age,
            'has_photo' => $hasPhoto,
            'present_photos' => $presentPhotos,
            'message' => $hasPhoto ? 'Profil récupéré avec succès.' : 'Aucune photo trouvée pour cet utilisateur.'
        ], 200);
    } catch (\Exception $e) {
        // Gestion des erreurs
        return response()->json([
            'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
        ], 500);
    }
}

    public function updateProfileField(Request $request, $id, $field)
    {
        $validatedData = $request->validate([
            $field => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        $user->update($validatedData);

        return response()->json(['success' => ucfirst($field) . ' mis à jour avec succès.'], 200);
    }

    public function updateName(Request $request, $id)
    {
        return $this->updateProfileField($request, $id, 'name');
    }

    public function updateNumero(Request $request, $id)
    {
        return $this->updateProfileField($request, $id, 'numero');
    }

    public function updateTown(Request $request, $id)
    {
        return $this->updateProfileField($request, $id, 'town');
    }

    public function updatePseudo(Request $request, $id)
    {
        return $this->updateProfileField($request, $id, 'pseudo');
    }

    public function showAllKaraokeProfiles()
    {
        try {
            $users = User::where('role', 'karaoke')
                         ->where('active', 1)
                         ->get();
    
            foreach ($users as $user) {
                $user->age = Carbon::parse($user->birthdate)->age;
    
                // Ajouter les liens de photos complets et compter les photos remplies
                $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
                $filledPhotosCount = 0;
                foreach ($photoFields as $photoField) {
                    if (!is_null($user->$photoField)) {
                        $user->$photoField = url('storage/' . $user->$photoField);
                        $filledPhotosCount++;
                    }
                }
                $user->filled_photos_count = $filledPhotosCount;
    
                // Générer l'URL WhatsApp avec le numéro de téléphone de l'utilisateur
                $user->whatsapp_url = "https://wa.me/{$user->numero}";
            }
    
            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            // Gestion des autres erreurs
            return response()->json([
                'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function showKaraokeProfile($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $age = Carbon::parse($user->birthdate)->age;
    
            // Ajouter les liens de photos complets et compter les photos remplies
            $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
            $filledPhotosCount = 0;
            $presentPhotos = [];
            foreach ($photoFields as $photoField) {
                if (!is_null($user->$photoField) && !empty($user->$photoField)) {
                    $filledPhotosCount++;
                    $presentPhotos[] = url('storage/' . $user->$photoField);
                }
            }
            $user->filled_photos_count = $filledPhotosCount;
            $user->present_photos = $presentPhotos;
    
            // Générer l'URL WhatsApp avec le numéro de téléphone de l'utilisateur
            $user->whatsapp_url = "https://wa.me/{$user->numero}";
    
            return response()->json([
                'user' => $user,
                'age' => $age,
                'filled_photos_count' => $filledPhotosCount,
                'present_photos' => $presentPhotos,
                'whatsapp_url' => $user->whatsapp_url
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Gestion des erreurs pour utilisateur non trouvé
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non trouvé.'
            ], 404);
        } catch (\Exception $e) {
            // Gestion des autres erreurs
            return response()->json([
                'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
            ], 500);
        }
    }


    public function Deco()
    {
        Auth::logout();
        return response()->json(['success' => 'Déconnexion réussie.'], 200);
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

        return response()->json(['success' => 'Paiement traité avec succès.'], 200);
    }

    public function visiteur($userId)
    {
        return response()->json(['userId' => $userId], 200);
    }

    public function Visiteurs(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'numero' => 'required|string',
        ]);

        $cleanedNumero = preg_replace('/\s+/', '', $validatedData['numero']);

        $user = User::findOrFail($userId);

        $newUser = User::create([
            'name' => $validatedData['name'],
            'numero' => $cleanedNumero,
            'role' => 'visiteur',
        ]);

        return response()->json(['newUser' => $newUser, 'userPhoneNumber' => $user->numero], 201);
    }

    public function showPhotoUploadForm($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json(['user' => $user], 200);
    }

    public function storePhotos(Request $request)
    {
        // Validation des données d'entrée
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'photo1' => 'nullable|image|max:2048',
        ]);
    
        try {
            // Trouver l'utilisateur
            $user = User::find($validatedData['user_id']);
    
            // Vérifier si un fichier photo a été fourni
            if ($request->hasFile('photo')) {
                // Stocker l'image
                $imagePath = $request->file('photo')->store('photos', 'public');
                $user->photo = $imagePath; // Assurez-vous que le champ photo existe dans votre modèle User
            }
    
            // Sauvegarder les modifications de l'utilisateur
            $user->save();
    
            return response()->json(['success' => 'Photo téléchargée avec succès.'], 200);
        } catch (\Exception $e) {
            // Retourner un message d'erreur en cas d'exception
            return response()->json(['error' => 'Erreur lors du téléchargement de la photo.', 'message' => $e->getMessage()], 500);
        }
    }
    
}
