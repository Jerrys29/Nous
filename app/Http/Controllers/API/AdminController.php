<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avis;
use App\Models\Publicite;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Parsedown;

class AdminController extends Controller
{
    public function loginUser(Request $request)
    {
        $credentials = $request->only('numero', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->active == 1) {
                if ($user->role == 'karaoke') {
                    $request->session()->regenerate();
                    return response()->json(['message' => 'Login successful', 'redirect' => route('profil')], 200);
                } else {
                    auth()->logout();
                    return response()->json(['error' => 'Erreur de connexion.'], 403);
                }
            } else {
                auth()->logout();
                return response()->json(['error' => 'Votre compte n\'est pas actif. Veuillez revenir dans quelques heures.'], 403);
            }
        } else {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }
    }

    public function showAllUsers()
    {
        $users = User::where('role', 'visiteur')->get();
        return response()->json(['users' => $users], 200);
    }

    public function blockUser($id, $redirect)
    {
        $user = User::find($id);

        if ($user->role === 'admin') {
            return response()->json(['error' => 'Vous ne pouvez pas bloquer l\'administrateur.'], 403);
        }

        $user->active = false;
        $user->save();

        return response()->json(['message' => 'User blocked successfully', 'redirect' => route($redirect)], 200);
    }

    public function unblockUser($id, $redirect)
    {
        $user = User::find($id);

        if ($user->role === 'admin') {
            return response()->json(['error' => 'Vous ne pouvez pas débloquer l\'administrateur.'], 403);
        }

        $user->active = true;
        
        if (is_null($user->activated_at)) {
            $user->activated_at = now();
        }

        $user->save();

        return response()->json(['message' => 'User unblocked successfully', 'redirect' => route($redirect)], 200);
    }

    public function showAllKaraokeUsers()
    {
        $users = User::where('role', 'karaoke')->get();
        return response()->json(['users' => $users], 200);
    }

    public function showLokKaraokeUsers()
    {
        $users = User::where('role', 'karaoke')->where('active', false)->get();
        return response()->json(['users' => $users], 200);
    }

    public function showAllNousUsers()
    {
        $users = User::where('role', 'nous')->get();
        return response()->json(['users' => $users], 200);
    }

    public function showLokNousUsers()
    {
        $users = User::where('role', 'nous')->where('active', true)->get();
        return response()->json(['users' => $users], 200);
    }

    public function Deco()
    {
        Auth::logout();
        return response()->json(['message' => 'Logout successful', 'redirect' => route('connection')], 200);
    }

    public function showavis()
    {
        $avisList = Avis::all();
        return response()->json(['avisList' => $avisList], 200);
    }

    public function index()
    {
        $publicites = Publicite::all();
        return response()->json(['publicites' => $publicites], 200);
    }

    public function createpub()
    {
        return response()->json(['message' => 'Create publicite page not implemented as JSON response.'], 501);
    }

    public function storepub(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'offre' => 'required|string',
            'detail' => 'required|string',
        ]);

        $parsedown = new Parsedown();
        $htmlDetail = $parsedown->text($validatedData['detail']);

        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('logos'), $logoName);
            $validatedData['logo'] = $logoName;
        }

        $validatedData['detail'] = $htmlDetail;
        Publicite::create($validatedData);

        return response()->json(['message' => 'Publicité créée avec succès.'], 201);
    }

    public function editpub($id)
    {
        $publicite = Publicite::findOrFail($id);
        return response()->json(['publicite' => $publicite], 200);
    }

    public function updatepub(Request $request, $id)
    {
        $publicite = Publicite::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'offre' => 'required|string',
            'detail' => 'required|string',
        ]);

        $parsedown = new Parsedown();
        $htmlDetail = $parsedown->text($validatedData['detail']);

        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('logos'), $logoName);
            $validatedData['logo'] = $logoName;
        }

        $validatedData['detail'] = $htmlDetail;
        $publicite->update($validatedData);

        return response()->json(['message' => 'Publicité mise à jour avec succès.'], 200);
    }

    public function toggleStatuspub($id)
    {
        $publicite = Publicite::findOrFail($id);
        $publicite->update(['statut' => !$publicite->statut]);

        return response()->json(['message' => 'Statut de la publicité modifié avec succès.'], 200);
    }

    public function search(Request $request)
    {
        $publicites = Publicite::query();

        if ($request->has('search')) {
            $search = $request->search;
            $publicites->where('name', 'like', "%$search%")
                       ->orWhere('offre', 'like', "%$search%");
        }

        $publicites = $publicites->get();

        return response()->json(['publicites' => $publicites], 200);
    }

    public function deleteUser($id, $redirect)
    {
        $user = User::find($id);

        if ($user->role === 'admin') {
            return response()->json(['error' => 'Vous ne pouvez pas supprimer l\'administrateur.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'L\'utilisateur a été supprimé avec succès.', 'redirect' => route($redirect)], 200);
    }

    public function blockNousUser($id, $redirect)
    {
        $user = User::find($id);

        if ($user->role === 'admin') {
            return response()->json(['error' => 'Vous ne pouvez pas bloquer l\'administrateur.'], 403);
        }

        if ($user->role !== 'nous') {
            return response()->json(['error' => 'Cet utilisateur n\'a pas le rôle "nous".'], 403);
        }

        $user->active = false;
        $user->save();

        return response()->json(['message' => 'User blocked successfully', 'redirect' => route($redirect)], 200);
    }

    public function unblockNousUser($id, $redirect)
    {
        $user = User::find($id);

        if ($user->role === 'admin') {
            return response()->json(['error' => 'Vous ne pouvez pas débloquer l\'administrateur.'], 403);
        }

        if ($user->role !== 'nous') {
            return response()->json(['error' => 'Cet utilisateur n\'a pas le rôle "nous".'], 403);
        }

        $user->active = true;

        if (is_null($user->activated_at)) {
            $user->activated_at = now();
        }

        $user->save();

        return response()->json(['message' => 'User unblocked successfully', 'redirect' => route($redirect)], 200);
    }
}
