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
        $identifier = $request->input('numero');
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'numero';

        $credentials = [
            $field => $identifier,
            'password' => $request->input('password'),
        ];

        if (Auth::once($credentials)) {
            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'message' => 'Authentification réussie'
            ]);
        }

        return response()->json([
            'error' => 'Identifiants incorrects',
            'message' => 'Les informations d\'identification sont incorrectes.'
        ], 401);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function view(Request $request)
    {
        $loggedInUser = auth()->user();

        // Initialisation des résultats à null par défaut
        $results = null;

        if (auth()->check()) {
            // Utilisateur connecté, appliquer les filtres et pagination
            $usersQuery = User::where('role', 'nous')
                ->where('active', 0)
                ->where('id', '!=', $loggedInUser->id);

            if ($loggedInUser->genre) {
                // Filtrer également par genre si spécifié
                $usersQuery->where('looking_for', $loggedInUser->genre);
            }

            $users = $usersQuery->paginate(12);

            if ($users->isEmpty()) {
                // Si aucun résultat avec les filtres spécifiés, retourner une autre pagination avec un fallback
                $fallbackUsers = User::where('role', 'nous')
                    ->where('looking_for', $loggedInUser->genre)
                    ->where('id', '!=', $loggedInUser->id)
                    ->paginate(6);

                $allusers = User::where('role', 'nous')
                    ->where('active', 0)
                    ->where('id', '!=', $loggedInUser->id)
                    ->paginate(12);

                return response()->json([
                    'fallbackUsers' => $fallbackUsers,
                    'allusers' => $allusers,
                    'message' => 'Aucun résultat trouvé avec les filtres spécifiés.'
                ]);
            }

            $allusers = User::where('role', 'nous')
                ->where('active', 0)
                ->where('id', '!=', $loggedInUser->id)
                ->paginate(12);

            return response()->json([
                'users' => $users,
                'allusers' => $allusers,
                'message' => 'Liste des profils récupérée avec succès.'
            ]);
        } else {
            // Utilisateur non connecté, retourner tous les utilisateurs avec pagination
            $users = User::where('role', 'nous')
                ->where('active', 0)
                ->paginate(12);

            return response()->json([
                'users' => $users,
                'message' => 'Liste des profils récupérée avec succès.'
            ]);
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
    

    public function updatePhotos(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if ($request->has('delete_photo1')) {
            if ($user->photo1) {
                Storage::delete($user->photo1);
                $user->photo1 = null;
            } else {
                return response()->json([
                    'error' => 'La photo 1 n\'existe pas.'
                ], 404);
            }
        }
        if ($request->has('delete_photo2')) {
            if ($user->photo2) {
                Storage::delete($user->photo2);
                $user->photo2 = null;
            } else {
                return response()->json([
                    'error' => 'La photo 2 n\'existe pas.'
                ], 404);
            }
        }
        if ($request->has('delete_photo3')) {
            if ($user->photo3) {
                Storage::delete($user->photo3);
                $user->photo3 = null;
            } else {
                return response()->json([
                    'error' => 'La photo 3 n\'existe pas.'
                ], 404);
            }
        }
        if ($request->has('delete_photo4')) {
            if ($user->photo4) {
                Storage::delete($user->photo4);
                $user->photo4 = null;
            } else {
                return response()->json([
                    'error' => 'La photo 4 n\'existe pas.'
                ], 404);
            }
        }
        if ($request->has('delete_photo5')) {
            if ($user->photo5) {
                Storage::delete($user->photo5);
                $user->photo5 = null;
            } else {
                return response()->json([
                    'error' => 'La photo 5 n\'existe pas.'
                ], 404);
            }
        }

        // Gestion de l'upload des nouvelles photos
        if ($request->hasFile('photo1')) {
            $imagePath = $request->file('photo1')->store('photos', 'public');
            $user->photo1 = $imagePath;
        }
        if ($request->hasFile('photo2')) {
            $imagePath = $request->file('photo2')->store('photos', 'public');
            $user->photo2 = $imagePath;
        }
        if ($request->hasFile('photo3')) {
            $imagePath = $request->file('photo3')->store('photos', 'public');
            $user->photo3 = $imagePath;
        }
        if ($request->hasFile('photo4')) {
            $imagePath = $request->file('photo4')->store('photos', 'public');
            $user->photo4 = $imagePath;
        }
        if ($request->hasFile('photo5')) {
            $imagePath = $request->file('photo5')->store('photos', 'public');
            $user->photo5 = $imagePath;
        }

        $user->save();

        return response()->json([
            'message' => 'Photos mises à jour avec succès.'
        ]);
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

    public function updatenumero(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        $user->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Numéro mis à jour avec succès.',
            'user' => $user  // Retourner l'utilisateur mis à jour si nécessaire
        ]);
    }

    public function updatename(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        $user->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Nom mis à jour avec succès.',
            'user' => $user  // Retourner l'utilisateur mis à jour si nécessaire
        ]);
    }

    public function updatepseudo(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pseudo' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé',
                'message' => 'L\'utilisateur avec cet ID n\'existe pas.'
            ], 404);
        }

        $user->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Pseudo mis à jour avec succès.',
            'user' => $user  // Retourner l'utilisateur mis à jour si nécessaire
        ]);
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
