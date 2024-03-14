<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Validation\Rule;

class NousController extends Controller
{

    public function index()
    {
        $messages = Discussion::all();
        return view('Nous.index', compact('messages'));
    }

    public function inscription()
    {
        return view('Nous.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
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

        $birthdate = new DateTime($validatedData['birthdate']);
        $today = new DateTime('now');
        $age = $birthdate->diff($today)->y;

        try {
            $userData = [
                'name' => $validatedData['name'],
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
                'role' => 'nous',
                'age' => $age,
            ];

            // Inclure le champ email uniquement s'il est fourni
            if (isset($validatedData['email'])) {
                $userData['email'] = $validatedData['email'];
            }

            User::create($userData);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Une erreur s\'est produite lors de l\'enregistrement. Veuillez réessayer.']);
        }

        return redirect()->route('login')->with('success', 'Inscription réussie! Vous pouvez maintenant vous connecter.');
    }




    public function edit(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role = 'nous') {
                return view('Nous/edit', compact('user'));
            } else {
                return view('Nous.login');
            }
        } else {
            return view('Nous.login');
        }
    }


    public function loginview()
    {
        return view('Nous.login');
    }

    public function login(Request $request)
    {
        $identifier = $request->input('numero');
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'numero';

        $credentials = [
            $field => $identifier,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('edit');
        }

        return back()->withErrors(['login' => 'Les informations d\'identification sont incorrectes.']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
    public function view()
    {
        $results = null; // Initialiser la variable $results à null par défaut
    
        if (auth()->check()) {
            $loggedInUser = auth()->user();
    
            $users = User::whereNotNull('photo1')
                ->where('role', 'nous')
                ->where('active', 0)
                ->where('id', '!=', $loggedInUser->id)
                ->get();
    
            if ($users->isEmpty()) {
                $fallbackUsers = User::whereNotNull('photo1')
                    ->where('role', 'nous')
                    ->where('looking_for', $loggedInUser->genre)
                    ->where('id', '!=', $loggedInUser->id)
                    ->get();
    
                return view('Nous.profils', compact('fallbackUsers', 'results')); // Passer également la variable $results à la vue
            }
    
            return view('Nous.profils', compact('users', 'results')); // Passer également la variable $results à la vue
        } else {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
    }
    

    public function detail($userId)
    {
        $user = User::findOrFail($userId);

        return view('Nous.detail', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->numero = $request->numero;
        $user->password = bcrypt($request->password); // Assurez-vous de hasher le mot de passe
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

        return redirect()->back()->with('success', 'Informations personnelles mises à jour avec succès.');
    }

    public function updatePhotos(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if ($request->has('delete_photo1')) {
            if ($user->photo1) {
                Storage::delete($user->photo1);
                $user->photo1 = null;
            } else {
                return redirect()->back()->with('error', 'La photo 1 n\'existe pas.');
            }
        }
        if ($request->has('delete_photo2')) {
            if ($user->photo2) {
                Storage::delete($user->photo2);
                $user->photo2 = null;
            } else {
                return redirect()->back()->with('error', 'La photo 1 n\'existe pas.');
            }
        }
        if ($request->has('delete_photo3')) {
            if ($user->photo3) {
                Storage::delete($user->photo3);
                $user->photo3 = null;
            } else {
                return redirect()->back()->with('error', 'La photo 1 n\'existe pas.');
            }
        }
        if ($request->has('delete_photo4')) {
            if ($user->photo4) {
                Storage::delete($user->photo4);
                $user->photo4 = null;
            } else {
                return redirect()->back()->with('error', 'La photo 1 n\'existe pas.');
            }
        }
        if ($request->has('delete_photo5')) {
            if ($user->photo5) {
                Storage::delete($user->photo5);
                $user->photo5 = null;
            } else {
                return redirect()->back()->with('error', 'La photo 1 n\'existe pas.');
            }
        }

        if ($request->hasFile('photo1')) {
            $imagePath = $request->file('photo1')->store('photos', 'public');
            $user->{'photo1'} = $imagePath;
        }
        if ($request->hasFile('photo2')) {
            $imagePath = $request->file('photo2')->store('photos', 'public');
            $user->{'photo2'} = $imagePath;
        }

        if ($request->hasFile('photo3')) {
            $imagePath = $request->file('photo3')->store('photos', 'public');
            $user->{'photo3'} = $imagePath;
        }
        if ($request->hasFile('photo4')) {
            $imagePath = $request->file('photo4')->store('photos', 'public');
            $user->{'photo4'} = $imagePath;
        }
        if ($request->hasFile('photo5')) {
            $imagePath = $request->file('photo5')->store('photos', 'public');
            $user->{'photo5'} = $imagePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Photos mises à jour avec succès.');
    }

    public function likeProfile($profile_id)
    {
        $user = auth()->user();

        $like = new Like([
            'liked_by' => $user->id,
            'like_to' => $profile_id,
        ]);

        $like->save();
        $profileOwner = User::find($profile_id);
        if ($profileOwner) {
            $notification = auth()->user()->name . ' a aimé votre profil.';
            Session::push("notifications_{$profileOwner->id}", $notification);
        }
        return redirect()->back();
    }

    public function unlikeProfile($profileId)
    {
        $user = auth()->user();
        $users = User::whereNotNull('photo1')
            ->where('looking_for', '=', $user->genre)
            ->where('role', '=', 'nous')
            ->where('interests', 'like', '%' . $user->interests . '%')
            ->where('id', '!=', $user->id)
            ->get();
        if ($user) {
            $user->likedProfiles()->detach($profileId);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function mettreAJourPaiement(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            DB::table('users')->where('id', $user->id)->update([
                'paiement' => 1,
                'paiement_date' => now()
            ]);
            return redirect()->back();
        }
        return response()->json(['paiementReussi' => false], 400);
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

    // Rediriger l'utilisateur vers une autre page ou afficher un message de succès
    return redirect()->route('avis')->with('success', 'Votre avis a été soumis avec succès ! Merci pour votre contribution.');


    }

    public function avisshow()
    {
        return view('Avis.vis');
        
    }

    public function storephoto1(Request $request)
    {
        $user = User::find($request->user_id);

        if ($request->hasFile('photo1')) {
            $imagePath = $request->file('photo1')->store('photos', 'public');
            $user->{'photo1'} = $imagePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Images sauvegardées avec succès.');
    }
    
    public function storephoto2(Request $request)
    {
        $user = User::find($request->user_id);

        if ($request->hasFile('photo2')) {
            $imagePath = $request->file('photo2')->store('photos', 'public');
            $user->{'photo2'} = $imagePath;
        }
        $user->save();
        return redirect()->back()->with('success', 'Images sauvegardées avec succès.');
    }

    public function storephoto3(Request $request)
    {
        $user = User::find($request->user_id);

        if ($request->hasFile('photo3')) {
            $imagePath = $request->file('photo3')->store('photos', 'public');
            $user->{'photo3'} = $imagePath;
        }
        $user->save();
        return redirect()->back()->with('success', 'Images sauvegardées avec succès.');
    }

    public function storephoto4(Request $request)
    {
        $user = User::find($request->user_id);

        if ($request->hasFile('photo4')) {
            $imagePath = $request->file('photo4')->store('photos', 'public');
            $user->{'photo4'} = $imagePath;
        }
        $user->save();
        return redirect()->back()->with('success', 'Images sauvegardées avec succès.');
    }

    public function storephoto5(Request $request)
    {
        $user = User::find($request->user_id);

        if ($request->hasFile('photo5')) {
            $imagePath = $request->file('photo5')->store('photos', 'public');
            $user->{'photo5'} = $imagePath;
        }
        $user->save();
        return redirect()->back()->with('success', 'Images sauvegardées avec succès.');
    }

    public function updatenumero(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero' => 'required|string',
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        $user->update($validatedData);
        return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
    }

    public function updatename(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        $user->update($validatedData);
        return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
    }

    public function updatepseudo(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pseudo' => 'required|string',
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        $user->update($validatedData);
        return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $loggedInUser = auth()->user();
    
        // Si l'utilisateur est authentifié, recherchez les utilisateurs correspondants
        if ($loggedInUser) {
            $users = User::whereNotNull('photo1')
                ->where('role', 'nous')
                ->where('active', 0)
                ->where('id', '!=', $loggedInUser->id)
                ->get();
    
            // Si aucun utilisateur correspondant n'est trouvé, recherchez les utilisateurs de secours
            if ($users->isEmpty()) {
                $fallbackUsers = User::whereNotNull('photo1')
                    ->where('role', 'nous')
                    ->where('looking_for', $loggedInUser->genre)
                    ->where('id', '!=', $loggedInUser->id)
                    ->get();
    
                return view('Nous.profils', ['users' => $fallbackUsers]);
            }
    
            // Recherchez les utilisateurs correspondant à la requête de recherche
            $results = User::whereNotNull('photo1')->where(function ($queryBuilder) use ($query) {
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
            
    
            // Passez les résultats à votre vue
            return view('Nous.profils', ['results' => $results, 'users' => $users, 'query' => $query]);
        }
    
        // Si l'utilisateur n'est pas authentifié, redirigez-le vers la page de connexion
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour effectuer une recherche.');
    }
    
    

}
    
