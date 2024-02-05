<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
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
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Validation\Rule;

class NousController extends Controller
{
    public function inscription()
    {
        return view('nous.register');
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

        return view('Nous/edit', compact('user'));
    }

    public function loginview()
    {
        return view('nous.login');
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
        if (auth()->check()) {
            $loggedInUser = auth()->user();
    
            $users = User::whereNotNull('photo1')
                ->where('role', 'nous')
                ->where('id', '!=', $loggedInUser->id);
    
            if ($loggedInUser->looking_for == 'lesdeux') {
                $users->where(function ($query) use ($loggedInUser) {
                    $query->where('looking_for', 'homme')
                          ->orWhere('looking_for', 'femme');
                });
            } else {
                $users->where('looking_for', $loggedInUser->looking_for);
            }
                if ($loggedInUser->interests) {
                $users->where('interests', 'like', '%' . $loggedInUser->interests . '%');
            }
    
            $users = $users->get();
                if ($users->isEmpty()) {
                $fallbackUsers = User::whereNotNull('photo1')
                    ->where('role', 'nous')
                    ->where('looking_for', $loggedInUser->genre)
                    ->where('id', '!=', $loggedInUser->id)
                    ->get();
    
                return view('nous.profils', ['users' => $fallbackUsers]);
            }
    
            return view('nous.profils', ['users' => $users]);
        } else {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }
    }
    
    

    public function detail($userId)
    {
        $user = User::findOrFail($userId);

        return view('nous.detail', ['user' => $user]);
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
    public function updateage(Request $request, $id)
    {
        $validatedData = $request->validate([
            'age' => 'required|string',
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        $user->update($validatedData);
        return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
    }
    public function updateabout(Request $request, $id)
    {
        $validatedData = $request->validate([
            'about' => 'required|string',
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        $user->update($validatedData);
        return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
    }
    public function updateinterests(Request $request, $id)
    {
        $validatedData = $request->validate([
            'interests' => 'required|string',
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        $user->update($validatedData);
        return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
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
            DB::table('users')->where('id', $user->id)->update(['paiement' => 1]);
            return redirect()->back();

        }
      return response()->json(['paiementReussi' => false], 400);
    }
}
