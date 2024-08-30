<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Publicite;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $messages = Discussion::all();
        $publicites = Publicite::where('statut', 1)->get();

        return response()->json([
            'messages' => $messages,
            'publicites' => $publicites
        ]);
    }

    public function inscription()
    {
        return response()->json([
            'view' => 'Nous.register'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
            'pseudo' => 'required|string',
            'town' => 'required|string',
            'birthdate' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'birthplace' => 'required|string',
            'genre' => 'required|string',
            'looking_for' => 'required|string',
            'mariatal_status' => 'required|string',
            'hair_color' => 'required|string',
            'eyes_color' => 'required|string',
            'numero' => [
                'required',
                'string',
                Rule::unique('users', 'numero')
            ],
            'password' => 'required|string',
            'origin_country' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validatedData = $validator->validated();

        $birthdate = new DateTime($validatedData['birthdate']);
        $today = new DateTime('now');
        $age = $today->diff($birthdate)->y;

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'pseudo' => $validatedData['pseudo'],
            'town' => $validatedData['town'],
            'birthdate' => $validatedData['birthdate'],
            'birthplace' => $validatedData['birthplace'],
            'genre' => $validatedData['genre'],
            'looking_for' => $validatedData['looking_for'],
            'mariatal_status' => $validatedData['mariatal_status'],
            'hair_color' => $validatedData['hair_color'],
            'eyes_color' => $validatedData['eyes_color'],
            'numero' => $validatedData['numero'],
            'password' => Hash::make($validatedData['password']),
            'origin_country' => $validatedData['origin_country'],
            'age' => $age,
            'role' => 'nous',
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }





    public function edit()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role === 'nous') {
                return response()->json(['user' => $user], 200);
            } else {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }


    public function loginview()
    {
        return response()->json(['message' => 'Login endpoint'], 200);
    }

 
    public function login(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'password' => 'required',
        ]);
        $identifier = $request->input('numero');
        $password = $request->input('password');
        Log::info('Tentative de connexion avec : ', ['numero' => $identifier]);
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'numero';
        $credentials = [
            $field => $identifier,
            'password' => $password,
        ];
        $user = User::where($field, $identifier)->first();
        if (!$user) {
            Log::warning('Utilisateur non trouvé avec : ' . $identifier);
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non trouvé.'
            ], 404);
        }
        if (Auth::attempt($credentials)) {
            Log::info('Utilisateur authentifié avec succès : ' . Auth::id());
            // Supprimer les anciens tokens pour cet utilisateur (optionnel)
            $user->tokens()->delete();
            // Créer un nouveau token
            $token = $user->createToken('AuthToken')->plainTextToken;
            // Log the generated token
            Log::info('Token généré pour l\'utilisateur ID : ' . $user->id . ' - Token : ' . $token);
            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token,
                'message' => 'Authentification réussie'
            ], 200);
        } else {
            Log::warning('Échec de l\'authentification pour l\'utilisateur ID : ' . $user->id);
            return response()->json([
                'status' => false,
                'message' => 'Les informations d\'identification sont incorrectes.'
            ], 401);
        }
        
}
    
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function view(Request $request)
    {
        try {
            // Récupérer l'utilisateur authentifié
            $loggedInUser = auth()->user();
            
            // Vérifier si l'utilisateur est authentifié
            if (!$loggedInUser) {
                return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
            }
    
            // Vérifier que les champs genre et looking_for de l'utilisateur connecté sont définis
            if (is_null($loggedInUser->genre) || is_null($loggedInUser->looking_for)) {
                return response()->json(['message' => 'Les champs genre ou looking_for ne sont pas définis pour l\'utilisateur connecté.'], 400);
            }
    
            // Construire la requête de base
            $usersQuery = User::where('role', 'nous')
                ->where('active', 0)
                ->where('id', '!=', $loggedInUser->id);
    
            // Ajouter les conditions de filtrage basées sur 'looking_for'
            if ($loggedInUser->looking_for == 'lesdeux') {
                $usersQuery->where(function ($query) {
                    $query->where('genre', 'homme')
                        ->orWhere('genre', 'femme');
                });
            } else {
                $usersQuery->where('genre', $loggedInUser->looking_for);
            }
    
            // Ajouter la condition pour le genre de l'utilisateur
            $usersQuery->where('looking_for', $loggedInUser->genre);
    
            // Exécuter la requête
            $users = $usersQuery->get();
    
            // Ajouter les liens de photos complets et compter le nombre de photos pour chaque utilisateur
            $users->each(function ($user) {
                $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
                $photoCount = 0;
                foreach ($photoFields as $photoField) {
                    if (!is_null($user->$photoField)) {
                        $user->$photoField = url('storage/' . $user->$photoField);
                    }
                }
            });
    
            // Si aucun utilisateur correspondant n'est trouvé
            if ($users->isEmpty()) {
                // Utilisateurs de secours si aucune correspondance trouvée
                $fallbackUsers = User::where('role', 'nous')
                    ->where('active', 0)
                    ->where('id', '!=', $loggedInUser->id)
                    ->where(function ($query) {
                        $query->whereNotNull('photo1')
                            ->orWhereNotNull('photo2')
                            ->orWhereNotNull('photo3')
                            ->orWhereNotNull('photo4')
                            ->orWhereNotNull('photo5');
                    })
                    ->get();
    
                // Ajouter les liens de photos complets et compter le nombre de photos pour chaque utilisateur
                $fallbackUsers->each(function ($user) {
                    $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
                    $photoCount = 0;
                    foreach ($photoFields as $photoField) {
                        if (!is_null($user->$photoField)) {
                            $user->$photoField = url('storage/' . $user->$photoField);
                        }
                    }
                });
    
                return response()->json([
                    'status' => true,
                    'users' => $fallbackUsers,
                    'message' => 'Aucun résultat trouvé avec les filtres spécifiés. Utilisateurs de secours fournis.'
                ]);
            }
    
            return response()->json([
                'status' => true,
                'users' => $users,
                'message' => 'Liste des profils récupérée avec succès.'
            ]);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return response()->json([
                'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    
    public function all(Request $request)
{
    try {
        // Récupérer tous les utilisateurs avec le rôle 'nous'
        $users = User::where('role', 'nous')
                ->where('photo1','!=',NULL)
                ->get();

        // Vérifier si des utilisateurs sont trouvés
        if ($users->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Aucun utilisateur trouvé avec le rôle spécifié.'
            ], 404);
        }

        // Construire l'URL complète pour chaque photo
        $users = $users->map(function ($user) {
            $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
            foreach ($photoFields as $photoField) {
                if (!is_null($user->$photoField)) {
                    $user->$photoField = url('storage/' . $user->$photoField);
                }
            }
            return $user;
        });

        return response()->json([
            'status' => true,
            'users' => $users,
            'message' => 'Liste des utilisateurs récupérée avec succès.'
        ], 200);
    } catch (\Exception $e) {
        // Gestion des erreurs
        return response()->json([
            'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
        ], 500);
    }
}

public function show($id)
{
    try {
        // Récupérer l'utilisateur par ID
        $user = User::find($id);

        // Ajouter les liens de photos complets et compter les photos remplies
        $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
        $filledPhotosCount = 0;

        foreach ($photoFields as $photoField) {
            if (!is_null($user->$photoField)) {
                $user->$photoField = url('storage/' . $user->$photoField);
                $filledPhotosCount++;
            }
        }

        // Générer l'URL WhatsApp avec le numéro de téléphone de l'utilisateur
        $whatsappUrl = "https://wa.me/{$user->numero}";

        return response()->json([
            'status' => true,
            'user' => $user,
            'filled_photos_count' => $filledPhotosCount,
            'whatsapp_url' => $whatsappUrl,
            'message' => 'Détails du profil récupérés avec succès.'
        ]);
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


public function countUserPhotos($id)
{
    try {
        // Récupérer l'utilisateur par ID
        $user = User::findOrFail($id);

        // Initialiser le compteur et le tableau des photos présentes
        $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
        $filledPhotosCount = 0;
        $presentPhotos = [];

        // Parcourir les champs de photo et les ajouter au tableau si elles sont présentes
        foreach ($photoFields as $photoField) {
            if (!is_null($user->$photoField) && !empty($user->$photoField)) {
                $filledPhotosCount++;
                $presentPhotos[] = url('storage/' . $user->$photoField);
            }
        }

        // Retourner la réponse JSON avec le nombre de photos remplies et les URLs des photos présentes
        return response()->json([
            'status' => true,
            'filled_photos_count' => $filledPhotosCount,
            'present_photos' => $presentPhotos,
            'message' => 'Nombre de photos remplies récupéré avec succès.'
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



    public function detail($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->numero = $request->numero;
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->pseudo = $request->pseudo;
        $user->age = $request->age;
        $user->genre = $request->genre;
        $user->looking_for = $request->looking_for;
        $user->town = $request->town;
        $user->origin_country = $request->origin_country;
        $user->birthplace = $request->birthplace;
        $user->mariatal_status = $request->mariatal_status;
        $user->hair_color = $request->hair_color;
        $user->eyes_color = $request->eyes_color;
        $user->about = $request->about;
        $user->interests = $request->interests;

        $user->save();

        return response()->json(['message' => 'Informations personnelles mises à jour avec succès.', 'user' => $user], 200);
    }

    public function uploadImage(Request $request)
    {
        // Valider la requête
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié.'
            ], 401);
        }
        // Gérer le téléchargement de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('photos', 'public');

            // Tableau pour les champs de photos
            $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];

            // Chercher le premier champ photo disponible
            $updated = false;
            foreach ($photoFields as $photoField) {
                if (is_null($user->$photoField)) {
                    // Mettre à jour le champ trouvé
                    $user->$photoField = $imagePath;
                    $updated = true;
                    break;
                }
            }
            if ($updated) {
                // Enregistrer les modifications
                $user->save();

                return response()->json([
                    'status' => true,
                    'user' => $user,
                    'message' => 'Image téléchargée avec succès.',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tous les champs de photos sont déjà remplis.',
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Aucun fichier téléchargé.',
            ], 400);
        }
    }
    
    public function checkPhotos(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié.'
            ], 401);
        }

        // Vérifier les champs de photos
        $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
        $hasPhoto = false;

        foreach ($photoFields as $photoField) {
            if (!is_null($user->$photoField)) {
                $hasPhoto = true;
                break;
            }
        }

        if ($hasPhoto) {
            return response()->json([
                'status' => true,
                'message' => 'L\'utilisateur a au moins une photo.'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Aucune photo trouvée pour cet utilisateur.'
            ], 404);
        }
    }

    public function updatePhotos(Request $request)
    {
        // Valider les entrées
        $request->validate([
            'photo1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        // Mettre à jour les photos
        $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
        foreach ($photoFields as $photoField) {
            if ($request->hasFile($photoField)) {
                // Supprimer l'ancienne photo si elle existe
                if (!is_null($user->$photoField)) {
                    Storage::delete('public/' . $user->$photoField);
                }

                // Enregistrer la nouvelle photo
                $path = $request->file($photoField)->store('photos', 'public');
                $user->$photoField = $path;
            }
        }
        // Sauvegarder les changements
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Photos mises à jour avec succès.',
            'user' => $user
        ], 200);
    }

    public function updateName(Request $request)
    {
        // Valider la requête
        $validatedData = $request->validate(['name' => 'required|string|max:255']);
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }    
        // Mettre à jour le nom de l'utilisateur
        $user->name = $request->name;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('name')) {
            return response()->json(['status' => true, 'message' => 'Name updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Name not updated'], 500);
        }
    }

    public function updateEmail(Request $request)
    {
        // Valider la requête
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users'
        ]);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            Log::info('Utilisateur non authentifié');
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
        
        Log::info('Utilisateur authentifié : ', ['user' => $user]);
    
        // Mettre à jour l'email de l'utilisateur
        $user->email = $request->email;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('email')) {
            Log::info('Email mis à jour avec succès : ', ['email' => $user->email]);
            return response()->json(['status' => true, 'message' => 'Email updated successfully', 'user' => $user], 200);
        } else {
            Log::warning('L\'email n\'a pas été mis à jour : ', ['email' => $user->email]);
            return response()->json(['status' => false, 'message' => 'Email not updated'], 500);
        }
    }
    
    public function updateLookingFor(Request $request)
    {
        // Valider la requête
        $request->validate(['looking_for' => 'required|string|max:255']);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    
        // Mettre à jour la préférence de l'utilisateur
        $user->looking_for = $request->looking_for;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('looking_for')) {
            return response()->json(['status' => true, 'message' => 'Looking for updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Looking for not updated'], 500);
        }
    }
    
    public function updatePassword(Request $request)
    {
        // Valider la requête
        $request->validate(['password' => 'required|string|min:8|confirmed']);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    
        // Mettre à jour le mot de passe de l'utilisateur
        $user->password = bcrypt($request->password);
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('password')) {
            return response()->json(['status' => true, 'message' => 'Password updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Password not updated'], 500);
        }
    }
    public function updateTown(Request $request)
    {
        // Valider la requête
        $request->validate(['town' => 'required|string|max:255']);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    
        // Mettre à jour la ville de l'utilisateur
        $user->town = $request->town;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('town')) {
            return response()->json(['status' => true, 'message' => 'Town updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Town not updated'], 500);
        }
    }
    public function updateNumero(Request $request)
    {
        // Valider la requête
        $request->validate(['numero' => 'required|string|max:255']);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    
        // Mettre à jour le numéro de l'utilisateur
        $user->numero = $request->numero;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('numero')) {
            return response()->json(['status' => true, 'message' => 'Numero updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Numero not updated'], 500);
        }
    }
    public function updatePseudo(Request $request)
    {
        // Valider la requête
        $request->validate(['pseudo' => 'required|string|max:255|unique:users']);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    
        // Mettre à jour le pseudo de l'utilisateur
        $user->pseudo = $request->pseudo;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('pseudo')) {
            return response()->json(['status' => true, 'message' => 'Pseudo updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Pseudo not updated'], 500);
        }
    }
    public function updateGenre(Request $request)
    {
        // Valider la requête
        $request->validate(['genre' => 'required|string|max:255']);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    
        // Mettre à jour le genre de l'utilisateur
        $user->genre = $request->genre;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('genre')) {
            return response()->json(['status' => true, 'message' => 'Genre updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Genre not updated'], 500);
        }
    }
    public function updateMariatalStatus(Request $request)
    {
        // Valider la requête
        $request->validate(['mariatal_status' => 'required|string|max:255']);
        
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    
        // Mettre à jour le statut marital de l'utilisateur
        $user->mariatal_status = $request->mariatal_status;
        $user->save();
    
        // Vérifier si la sauvegarde a réussi
        if ($user->wasChanged('mariatal_status')) {
            return response()->json(['status' => true, 'message' => 'Mariatal status updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Mariatal status not updated'], 500);
        }
    }
                            

    public function likeProfile(Request $request, $id)
    {
        try {
            // Vérifier si l'utilisateur est authentifié
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Utilisateur non authentifié. Veuillez vous connecter pour aimer un profil.'
                ], 401);
            }
    
            // Vérifier si l'utilisateur a déjà aimé ce profil
            $existingLike = Like::where('liked_by', $user->id)
                                ->where('like_to', $id)
                                ->first();
    
            if ($existingLike) {
                // Si l'utilisateur a déjà aimé, supprimer le like (unlike)
                $existingLike->delete();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Vous avez retiré votre like de ce profil.',
                    'already_liked' => false, // Indique que le like a été retiré
                ], 200);
            } else {
                // Si l'utilisateur n'a pas encore aimé, créer un nouvel enregistrement de like
                $like = new Like([
                    'liked_by' => $user->id,
                    'like_to' => $id,
                    'message' => $user->name . ' a aimé votre profil.'
                ]);
    
                $like->save();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Profil aimé avec succès.',
                    'already_liked' => true, // Indique que le like a été ajouté
                    'like' => $like,
                ], 200);
            }
    
        } catch (\Exception $e) {
            // Gestion des erreurs
            return response()->json([
                'status' => false,
                'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function unlikeProfile($profileId)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'error' => 'Non authentifié',
                'message' => 'Vous devez être connecté pour désaimer un profil.'
            ], 401);
        }

        // Détacher le profil aimé
        $user->likedProfiles()->detach($profileId);

        return response()->json([
            'message' => 'Profil désaimé avec succès.',
        ]);
    }

    
    public function processPaiement(Request $request)
    {
        try {
            // Vérifier si l'utilisateur est authentifié
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Utilisateur non authentifié. Veuillez vous connecter pour effectuer un paiement.'
                ], 401);
            }

            // Définir le montant du paiement
            $amount = 981; // par exemple 981 FCFA

            // Intégrer l'API Kkiapay
            $kkiapayUrl = 'https://api.kkiapay.me/api/v1/transactions';
            $apikey = 'de9c4e671f1c676a8613e0a567252e182c8fc52c';
            $callbackUrl = 'Homepage';

            $response = Http::withHeaders([
                'Authorization' => "Bearer $apikey"
            ])->post($kkiapayUrl, [
                'amount' => $amount,
                'apikey' => $apikey,
                'callback_url' => $callbackUrl,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->numero,
            ]);

            // Analyser la réponse
            $responseBody = $response->json();
            if ($response->successful() && $responseBody['status'] == 'success') {
                // Mise à jour du statut de paiement de l'utilisateur
                $user->paiement = 1; // Met à jour le champ 'paiement' pour indiquer le succès
                $user->paiement_date = now();
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Paiement réussi et abonnement mis à jour.'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Le paiement a échoué, veuillez réessayer.'
                ], 400);
            }

        } catch (\Exception $e) {
            // Gestion des erreurs
            return response()->json([
                'status' => false,
                'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
            ], 500);
        }
    }


    public function mettreAJourPaiement(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'error' => 'Non authentifié',
                'message' => 'Vous devez être connecté pour effectuer cette action.'
            ], 401);
        }

        // Mettre à jour les informations de paiement de l'utilisateur
        DB::table('users')->where('id', $user->id)->update([
            'paiement' => 1,
            'paiement_date' => now()
        ]);

        // Retourner une réponse JSON indiquant que le paiement a été réussi
        return response()->json(['paiementReussi' => true], 200);
    }

    public function checkPaymentStatus()
    {
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié.'
            ], 401);
        }
    
        // Vérifier le statut de paiement
        if ($user->paiement == 1) {
            return response()->json([
                'status' => true,
                'message' => 'Paiement confirmé.'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Paiement non confirmé.'
            ], 500);
        }
    }
    
    

    public function updateAbout(Request $request, $id)
    {
        $request->validate([
            'about' => 'nullable|string|max:1000',
        ]);

        $user = User::findOrFail($id);
        $user->about = $request->input('about');
        $user->save();

        return response()->json(['message' => 'About updated successfully'], 200);
    }

    public function updateinterests(Request $request, $id)
    {
        $request->validate([
            'interests' => 'nullable|string|max:1000',
        ]);

        $user = User::findOrFail($id);
        $user->interests = $request->input('interests');
        $user->save();

        return response()->json(['message' => 'Interests updated successfully'], 200);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $loggedInUser = auth()->user();

        // Si l'utilisateur est authentifié, recherchez les utilisateurs correspondants
        if ($loggedInUser) {
            $users = User::where('role', 'nous')
                ->where('active', 0)
                ->where('id', '!=', $loggedInUser->id)
                ->get();

            // Recherchez les utilisateurs correspondant à la requête de recherche
            $results = User::where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                    ->orWhere('pseudo', 'like', "%$query%")
                    ->orWhere('town', 'like', "%$query%")
                    ->orWhere('birthplace', 'like', "%$query%")
                    ->orWhere('genre', 'like', "%$query%")
                    ->orWhere('looking_for', 'like', "%$query%")
                    ->orWhere('mariatal_status', 'like', "%$query%")
                    ->orWhere('hair_color', 'like', "%$query%")
                    ->orWhere('eyes_color', 'like', "%$query%")
                    ->orWhere('origin_country', 'like', "%$query%")
                    ->orWhere('age', 'like', "%$query%")
                    ->orWhere('about', 'like', "%$query%")
                    ->orWhere('interests', 'like', "%$query%");
            })->get();

            // Retournez une réponse JSON avec les résultats de la recherche
            return response()->json([
                'results' => $results,
                'users' => $users,
                'query' => $query
            ]);
        }

        // Si l'utilisateur n'est pas authentifié, retournez une réponse JSON avec un message d'erreur
        return response()->json([
            'error' => 'Non authentifié',
            'message' => 'Vous devez être connecté pour effectuer une recherche.'
        ], 401);
    }


    public function getAuthenticatedUser()
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
           
                    $photo1 = url('storage/' . $user->photo1);
                    $photo2 = url('storage/' . $user->photo2);
                    $photo3 = url('storage/' . $user->photo3);
                    $photo4 = url('storage/' . $user->photo4);
                    $photo5 = url('storage/' . $user->photo5);
            return response()->json([
                'status' => true,
                'user' => $user,
                'photo1'=>$photo1,
                'photo2'=>$photo2,
                'photo3'=>$photo3,
                'photo4'=>$photo4,
                'photo5'=>$photo5,
                'message' => 'Informations utilisateur récupérées avec succès.'
            ], 200);
        } catch (\Exception $e) {
            // Gestion des autres erreurs
            return response()->json([
                'status' => false,
                'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
            ], 500);
        }
    }
    public function showNotifications()
    {
        try {
            // Vérifier si l'utilisateur est authentifié
            if (!auth()->check()) {
                return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
            }
    
            // Récupérer l'utilisateur connecté
            $user = auth()->user();

            // Récupérer les notifications de l'utilisateur connecté depuis la base de données
            $notifications = Like::where('like_to', $user->id)->get();
            
            // Préparer la réponse avec les notifications
            $formattedNotifications = $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'like_from' => $notification->liked_by,
                    'message' => $notification->message, // Le message est déjà dans la base de données
                    'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
                ];
            });
    
            return response()->json([
                'status' => true,
                'notifications' => $formattedNotifications,
                'message' => 'Notifications récupérées avec succès.'
            ]);
        } catch (\Exception $e) {
            // Gestion des erreurs
            return response()->json([
                'status' => false,
                'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
            ], 500);
        }
    }
    
    

}
