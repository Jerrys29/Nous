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
        $validatedData = $request->validate([
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

        $cleanedNumero = preg_replace('/\s+/', '', $validatedData['numero']);

        if (User::where('numero', $cleanedNumero)->exists()) {
            return response()->json(['error' => 'Ce numéro est déjà utilisé.'], 400);
        }

        $hashedPassword = Hash::make($validatedData['password']);

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

        $token = $user->createToken('Nous&Karaoke')->plainTextToken;

        return response()->json([
            'success' => 'Inscription réussie',
            'token' => $token
        ], 201);
    }

    public function show()
    {
        return response()->json(['user' => Auth::user()], 200);
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
        $validatedData = $request->validate([
            'numero' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'numero' => preg_replace('/\s+/', '', $validatedData['numero']),
            'password' => $validatedData['password'],
        ];

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->active == 1) {
                $token = $user->createToken('Nous&Karaoke')->plainTextToken;
                return response()->json([
                    'success' => 'Connexion réussie',
                    'role' => $user->role,
                    'token' => $token
                ], 200);
            } else {
                auth()->logout();
                return response()->json(['error' => 'Votre compte n\'est pas actif.'], 403);
            }
        } else {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }
    }

    public function showprofil()
    {
        $user = Auth::user();
        $age = Carbon::parse($user->birthdate)->age;
        return response()->json(['user' => $user, 'age' => $age], 200);
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
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'photo1' => 'nullable|image|max:2048',
            'photo2' => 'nullable|image|max:2048',
        ]);

        $user = User::find($validatedData['user_id']);

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
