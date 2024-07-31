<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avis;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Publicite;
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
    
            // Exécuter la requête avec pagination
            $users = $usersQuery->paginate(12);
    
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
                    ->paginate(12);
    
                // Ajouter les liens de photos complets
                $fallbackUsers->each(function ($user) {
                    $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
                    foreach ($photoFields as $photoField) {
                        if (!is_null($user->$photoField)) {
                            $user->$photoField = url('storage/' . $user->$photoField);
                        }
                    }
                });
    
                return response()->json([
                    'fallbackUsers' => $fallbackUsers,
                    'message' => 'Aucun résultat trouvé avec les filtres spécifiés.'
                ]);
            }
    
            // Ajouter les liens de photos complets
            $users->each(function ($user) {
                $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5'];
                foreach ($photoFields as $photoField) {
                    if (!is_null($user->$photoField)) {
                        $user->$photoField = url('storage/' . $user->$photoField);
                    }
                }
            });
    
            return response()->json([
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


    public function likeProfile($profile_id)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'error' => 'Non authentifié',
                'message' => 'Vous devez être connecté pour aimer un profil.'
            ], 401);
        }

        $like = new Like([
            'liked_by' => $user->id,
            'like_to' => $profile_id,
            'message' => $user->name . ' a aimé votre profil.'
        ]);

        $like->save();
        $profileOwner = User::find($profile_id);

        return response()->json([
            'message' => 'Profil aimé avec succès.',
            'like' => $like, // Vous pouvez retourner les détails du like si nécessaire
            'profileOwner' => $profileOwner // Retournez également les détails du propriétaire du profil si nécessaire
        ]);
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


    public function avis(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'comment' => 'required|string',
        ]);

        // Supprimer les espaces dans le numéro de téléphone
        $phone = str_replace(' ', '', $validatedData['phone']);

        // Créer un nouvel avis en utilisant le modèle Avis
        $avis = Avis::create([
            'name' => $validatedData['name'],
            'phone' => $phone,
            'comment' => $validatedData['comment'],
        ]);

        // Retourner une réponse JSON pour indiquer que l'avis a été soumis avec succès
        return response()->json([
            'success' => true,
            'message' => 'Votre avis a été soumis avec succès ! Merci pour votre contribution.',
            'avis' => $avis, // Vous pouvez retourner les détails de l'avis si nécessaire
        ]);
    }

    public function avisshow()
    {
        return response()->json([
            'error' => 'Ressource non disponible',
            'message' => 'Cette route n\'est pas accessible via l\'API.'
        ], 404);
    }

    public function storephoto1(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        if ($request->hasFile('photo1')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo1) {
                Storage::delete($user->photo1);
            }

            // Enregistrer la nouvelle photo
            $imagePath = $request->file('photo1')->store('photos', 'public');
            $user->photo1 = $imagePath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo 1 enregistrée avec succès.',
                'photo_url' => asset('storage/' . $imagePath)  // Retourner l'URL complète de l'image si nécessaire
            ]);
        }

        return response()->json([
            'error' => 'Aucune image envoyée',
            'message' => 'Veuillez fournir une image pour mettre à jour la photo 1.'
        ], 400);
    }

    public function storephoto2(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        if ($request->hasFile('photo2')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo2) {
                Storage::delete($user->photo2);
            }

            // Enregistrer la nouvelle photo
            $imagePath = $request->file('photo2')->store('photos', 'public');
            $user->photo2 = $imagePath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo 1 enregistrée avec succès.',
                'photo_url' => asset('storage/' . $imagePath)  // Retourner l'URL complète de l'image si nécessaire
            ]);
        }

        return response()->json([
            'error' => 'Aucune image envoyée',
            'message' => 'Veuillez fournir une image pour mettre à jour la photo 1.'
        ], 400);
    }
    public function storephoto3(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        if ($request->hasFile('photo3')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo3) {
                Storage::delete($user->photo3);
            }

            // Enregistrer la nouvelle photo
            $imagePath = $request->file('photo3')->store('photos', 'public');
            $user->photo3 = $imagePath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo 1 enregistrée avec succès.',
                'photo_url' => asset('storage/' . $imagePath)  // Retourner l'URL complète de l'image si nécessaire
            ]);
        }

        return response()->json([
            'error' => 'Aucune image envoyée',
            'message' => 'Veuillez fournir une image pour mettre à jour la photo 1.'
        ], 400);
    }
    public function storephoto4(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        if ($request->hasFile('photo4')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo4) {
                Storage::delete($user->photo4);
            }

            // Enregistrer la nouvelle photo
            $imagePath = $request->file('photo4')->store('photos', 'public');
            $user->photo4 = $imagePath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo 1 enregistrée avec succès.',
                'photo_url' => asset('storage/' . $imagePath)  // Retourner l'URL complète de l'image si nécessaire
            ]);
        }

        return response()->json([
            'error' => 'Aucune image envoyée',
            'message' => 'Veuillez fournir une image pour mettre à jour la photo 1.'
        ], 400);
    }

    public function storephoto5(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        if ($request->hasFile('photo5')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo5) {
                Storage::delete($user->photo5);
            }

            // Enregistrer la nouvelle photo
            $imagePath = $request->file('photo5')->store('photos', 'public');
            $user->photo5 = $imagePath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo 1 enregistrée avec succès.',
                'photo_url' => asset('storage/' . $imagePath)  // Retourner l'URL complète de l'image si nécessaire
            ]);
        }

        return response()->json([
            'error' => 'Aucune image envoyée',
            'message' => 'Veuillez fournir une image pour mettre à jour la photo 1.'
        ], 400);
    }
    public function updatename(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->save();

        return response()->json(['message' => 'Name updated successfully'], 200);
    }

    public function updatenumero(Request $request, $id)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->numero = $request->input('numero');
        $user->save();

        return response()->json(['message' => 'Numero updated successfully'], 200);
    }

    public function updatepassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    public function updatepseudo(Request $request, $id)
    {
        $request->validate([
            'pseudo' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->pseudo = $request->input('pseudo');
        $user->save();

        return response()->json(['message' => 'Pseudo updated successfully'], 200);
    }

    public function updateage(Request $request, $id)
    {
        $request->validate([
            'age' => 'required|integer|min:0',
        ]);

        $user = User::findOrFail($id);
        $user->age = $request->input('age');
        $user->save();

        return response()->json(['message' => 'Age updated successfully'], 200);
    }

    public function updateabout(Request $request, $id)
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

    public function showNotifications()
    {
        // Récupérer les notifications de l'utilisateur connecté depuis la base de données
        $notifications = Like::where('like_to', auth()->user()->id)->get();

        // Retourner une réponse JSON avec les notifications récupérées
        return response()->json([
            'notifications' => $notifications
        ]);
    }
}
