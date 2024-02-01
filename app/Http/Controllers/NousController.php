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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View as FacadesView;

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
            'pseudo' => 'required|string',
            'town' => 'required|string',
            'birthdate' => 'required|date',
            'birthplace' => 'required|string',
            'looking_for' => 'required|string',
            'mariatal_status' => 'required|string',
            'hair_color' => 'required|string',
            'eyes_color' => 'required|string',
            'numero' => 'required|string',
            'password' => 'required|string',
            'origin_country' => 'required|string',

        ]);

        $user = new User;
        $user->name = $validatedData['name'];
        $user->pseudo = $validatedData['pseudo'];
        $user->town = $validatedData['town'];
        $user->birthdate = $validatedData['birthdate'];
        $user->birthplace = $validatedData['birthplace'];
        $user->looking_for = $validatedData['looking_for'];
        $user->mariatal_status = $validatedData['mariatal_status'];
        $user->hair_color = $validatedData['hair_color'];
        $user->numero = $validatedData['numero'];
        $user->password = Hash::make($validatedData['password']); // Hachage du mot de passe
        $user->origin_country = $validatedData['origin_country'];
        $user->role = 'nous';
        $birthdate = new DateTime($validatedData['birthdate']);
        $today = new DateTime('now');
        $age = $birthdate->diff($today)->y;
        $user->age = $age;
        $user->save();
        return redirect()->route('login');
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
        $credentials = $request->only('numero', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('edit');
        }

        return back()->withErrors(['login' => 'Les informations d\'identification sont incorrectes.']);
    }

    public function view()
    {

        $loggedInUser = auth()->user();

        $users = User::whereNotNull('photo1')
            ->where('looking_for', '=', $loggedInUser->genre)
            ->where('role', '=', 'nous')
            ->where('interests', 'like', '%' . $loggedInUser->interests . '%')
            ->where('id', '!=', $loggedInUser->id)
            ->get();
        return view('nous.profils', ['users' => $users]);
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
        $users = User::whereNotNull('photo1')
            ->where('looking_for', '=', $user->genre)
            ->where('role', '=', 'nous')
            ->where('interests', 'like', '%' . $user->interests . '%')
            ->where('id', '!=', $user->id)
            ->get();
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
        return view('nous.profils', ['users' => $users]);
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
            return view('nous.profils', ['users' => $users]);
        }
        return view('nous.profils', ['users' => $users]);
    }

    public function mettreAJourPaiement(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Vérifier si l'utilisateur est connecté et si le paiement a été réussi
        if ($user) {
            // Mettre à jour le champ "paiement" de l'utilisateur
            DB::table('users')->where('id', $user->id)->update(['paiement' => 1]);

            return response()->json(['paiementReussi' => true], 200);
        }

        return response()->json(['paiementReussi' => false], 400);
    }
}
