<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Paiements;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ApiKaraokeController extends Controller
{
    public function register(Request $request)
    {
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

        $cleanedNumero = preg_replace('/\s+/', '', $request->input('numero'));

        if (User::where('numero', $cleanedNumero)->exists()) {
            return response()->json(['error' => 'Impossible d\'utiliser ce numéro pour vous inscrire. Veuillez utiliser un autre numéro.'], 400);
        }

        $hashedPassword = Hash::make($request->input('password'));

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

        return response()->json(['success' => 'Inscription réussie', 'userId' => $user->id], 201);
    }

    public function show()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    public function showRegistration()
    {
        return response()->json(['message' => 'Formulaire d\'inscription'], 200);
    }

    public function checkPhoneNumber($phoneNumber)
    {
        $exists = User::where('numero', $phoneNumber)->exists();
        return response()->json(['exists' => $exists], 200);
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('numero', 'password');
        $credentials['numero'] = preg_replace('/\s+/', '', $credentials['numero']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->active == 1) {
                $request->session()->regenerate();
                return response()->json(['success' => 'Connexion réussie', 'role' => $user->role], 200);
            } else {
                auth()->logout();
                return response()->json(['error' => 'Votre compte n\'est pas actif. Veuillez revenir dans quelques heures.'], 403);
            }
        } else {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }
    }

    public function showprofil()
    {
        $user = Auth::user();
        $age = Carbon::parse($user->birthdate)->age;
        return response()->json(['user' => $user, 'age' => $user->age], 200);
    }

    public function showUserProfile()
    {
        $user = Auth::user();

        if ($user->role == 'karaoke' && $user->activity == 1) {
            $age = Carbon::parse($user->birthdate)->age;
            return response()->json(['user' => $user, 'age' => $age], 200);
        } else {
            return response()->json(['error' => 'Vous devez être connecté pour accéder à cette page.'], 403);
        }
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

        return response()->json(['success' => 'Nom mis à jour avec succès.'], 200);
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

        return response()->json(['success' => 'Numéro mis à jour avec succès.'], 200);
    }

    public function updateTown(Request $request, $id)
    {
        $validatedData = $request->validate([
            'town' => 'required|string',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        $user->update($validatedData);

        return response()->json(['success' => 'Ville mise à jour avec succès.'], 200);
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

        return response()->json(['success' => 'Pseudo mis à jour avec succès.'], 200);
    }

    public function showAllKaraokeProfiles()
    {
        $users = User::where('role', 'karaoke')
                     ->where('active', 1)
                     ->get();

        foreach ($users as $user) {
            $user->age = Carbon::parse($user->birthdate)->age;
        }

        return response()->json(['users' => $users], 200);
    }

    public function showKaraokeProfile($userId)
    {
        $user = User::findOrFail($userId);
        $age = Carbon::parse($user->birthdate)->age;
        return response()->json(['user' => $user, 'age' => $age], 200);
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
        $request->validate([
            'name' => 'required|string',
            'numero' => 'required|string',
        ]);

        $cleanedNumero = preg_replace('/\s+/', '', $request->input('numero'));

        $user = User::findOrFail($userId);

        $newUser = User::create([
            'name' => $request->input('name'),
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
        $user = User::find($request->user_id);

        for ($i = 1; $i <= 2; $i++) {
            $photoKey = 'photo' . $i;
            if ($request->hasFile($photoKey)) {
                $imagePath = $request->file($photoKey)->store('photos', 'public');
                $user->{$photoKey} = $imagePath;
            }
        }

        $user->save();

        return response()->json(['success' => 'Photos téléchargées avec succès.'], 200);
    }
}
