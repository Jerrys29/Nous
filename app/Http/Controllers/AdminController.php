<?php

namespace App\Http\Controllers;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avis;
use App\Models\Publicite;
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



class AdminController extends Controller
{


        public function loginUser(Request $request)
    {
        $credentials = $request->only('numero', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->active == 1) {
                // gérer les différents rôles et rediriger en conséquence
                if ($user->role == 'karaoke') {
                    $request->session()->regenerate();
                    return redirect()->route('profil'); // 
                } else {
                    // Redirigez vers la page de connexion avec un message d'erreur
                    auth()->logout();
                    return redirect()->route('login')->withErrors(['credentials' => 'Erreur de connexion.'])->withInput();
                }
            } else {
                // Si le champ 'active' n'est pas égal à 1, l'utilisateur n'est pas autorisé
                auth()->logout();
                return redirect()->route('login')->withErrors(['active' => 'Votre compte n\'est pas actif. Veuillez revenir dans quelques heures.'])->withInput();
            }
        } else {
            // Si l'authentification échoue, redirigez avec des erreurs
            return redirect()->route('login')->withErrors(['credentials' => 'Identifiants invalides'])->withInput();
        }
    }

    // AdminController
    public function showAllUsers()
    {
        // Récupérer tous les utilisateurs
        $users  = User::where('role', 'visiteur')->get();

        // Passer les données à la vue
        return view('Admin/users', compact('users'));
    }


    public function blockUser($id, $redirect)
{
    // Récupérer l'utilisateur à bloquer
    $user = User::find($id);

    // Vérifier si l'utilisateur en question est l'administrateur lui-même
    if ($user->role === 'admin') {
        return redirect()->route($redirect)->withErrors(['error' => 'Vous ne pouvez pas bloquer l\'administrateur.']);
    }

    // Changer le statut de l'utilisateur
    $user->active = false;

    $user->save();

    // Rediriger vers la page des utilisateurs correspondante
    return redirect()->route($redirect);
}
    
public function unblockUser($id, $redirect)
{
    // Récupérer l'utilisateur à débloquer
    $user = User::find($id);

    // Vérifier si l'utilisateur en question est l'administrateur lui-même
    if ($user->role === 'admin') {
        return redirect()->route($redirect)->withErrors(['error' => 'Vous ne pouvez pas débloquer l\'administrateur.']);
    }

    // Changer le statut de l'utilisateur
    $user->active = true;
    
    // Si la colonne activated_at est nulle, mettre à jour avec la date actuelle
    if (is_null($user->activated_at)) {
        $user->activated_at = now();
    }
    
    // Sauvegarder les modifications
    $user->save();

    // Rediriger vers la page des utilisateurs correspondante
    return redirect()->route($redirect);
}

    
    // AdminController KaraokeUsers
    

    public function showAllKaraokeUsers()
    {
       
         // Récupérer tous les utilisateurs avec le rôle "karaoke"
         $users  = User::where('role', 'karaoke')->get();

        // Passer les données à la vue
        return view('Admin/KaraokeUsers', compact('users'));
    }

    public function showLokKaraokeUsers()
    {
        // Récupérer tous les utilisateurs avec le rôle "karaoke" et un compte bloqué
        $users = User::where('role', 'karaoke')->where('active', false)->get();

        // Passer les données à la vue
        return view('Admin/LokKaraokeUsers', compact('users'));
    }
    // public function showVisiteurUsers()
    // {
    //     // Récupérer tous les utilisateurs avec le rôle "karaoke" et un compte bloqué
    //     $users = User::where('role', 'visiteur')->get();

    //     // Passer les données à la vue
    //     return view('Admin/uspaie', compact('users'));
    // }

    // AdminController NousUsers
    public function showAllNousUsers()
    {
        // Récupérer tous les utilisateurs sans le rôle "karaoke"
        $users = User::where('role',  'nous')->get();

        // Passer les données à la vue
        return view('Admin/NousUsers', compact('users'));
    }

    public function showLokNousUsers()
    {
        // Récupérer tous les utilisateurs sans le rôle "karaoke" et un compte bloqué
        $users = User::where('role',  'nous')->where('active', true)->get();

        // Passer les données à la vue
        return view('Admin/LokNousUsers', compact('users'));
    }
   


    public function Deco()
    {
        Auth::logout();
    
        return redirect('/connection');
    }
     
    public function showavis()
    {
        // Récupérer tous les avis
        $avisList = Avis::all();

        // Passer les données à la vue
        return view('Admin/avis', compact('avisList'));
    }


    public function index()
    {
        $publicites = Publicite::all();
        return view('Admin.publicite.index', compact('publicites'));
    }

 

    public function createpub()
    {
        return view('Admin.publicite.create');
    }

    public function storepub(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'offre' => 'required|string',
            'detail' => 'required|string',
        ]);
        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('logos'), $logoName); // Déplacement du fichier vers le dossier public/logos
            $validatedData['logo'] = $logoName;
        }
        Publicite::create($validatedData);

        return redirect()->route('publicites')->with('success', 'Publicité créée avec succès.');
    }

    public function editpub($id)
    {
        $publicite = Publicite::findOrFail($id);
        return view('Admin.publicite.edit', compact('publicite'));
    }

    public function updatepub(Request $request, $id)
    {
        $publicite = Publicite::findOrFail($id);
        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('logos'), $logoName); // Déplacement du fichier vers le dossier public/logos
            $validatedData['logo'] = $logoName;
        }
        $publicite->update($request->all());

        return redirect()->route('publicites')->with('success', 'Publicité mise à jour avec succès.');
    }

    public function toggleStatuspub($id)
    {
        // Trouver la publicité correspondante
        $publicite = Publicite::findOrFail($id);
        
        // Inverser la valeur de la propriété "statut"
        $publicite->update(['statut' => !$publicite->statut]);
    
        // Rediriger avec un message de succès
        return redirect()->route('publicites')->with('success', 'Statut de la publicité modifié avec succès.');
    }
    
    public function search(Request $request)
    {
        $publicites = Publicite::query();

        // Vérifie si une recherche est effectuée
        if ($request->has('search')) {
            $search = $request->search;
            $publicites->where('name', 'like', "%$search%")
                   ->orWhere('offre', 'like', "%$search%");
        }

        // Récupère les vidéos filtrées
        $publicite = $publicites->get();

        // Retourne les vidéos filtrées à la vue
        return view('Admin.publicite.index', compact('publicites'));
    }
    

    public function deleteUser($id, $redirect)
    {
        // Récupérer l'utilisateur à supprimer
        $user = User::find($id);

        // Vérifier si l'utilisateur en question est l'administrateur lui-même
        if ($user->role === 'admin') {
            return redirect()->route($redirect)->withErrors(['error' => 'Vous ne pouvez pas supprimer l\'administrateur.']);
        }

        // Supprimer l'utilisateur
        $user->delete();

        // Rediriger vers la page des utilisateurs correspondante
        return redirect()->route($redirect)->with('success', 'L\'utilisateur a été supprimé avec succès.');
    }

    public function blockNousUser($id, $redirect)
{
    // Récupérer l'utilisateur à bloquer
    $user = User::find($id);

    // Vérifier si l'utilisateur en question est l'administrateur lui-même
    if ($user->role === 'admin') {
        return redirect()->route($redirect)->withErrors(['error' => 'Vous ne pouvez pas bloquer l\'administrateur.']);
    }

    // Rediriger si l'utilisateur n'a pas le rôle "nous"
    if ($user->role !== 'nous') {
        return redirect()->route($redirect)->withErrors(['error' => 'Cet utilisateur n\'a pas le rôle "nous".']);
    }

    // Changer le statut de l'utilisateur à non actif
    $user->active = false;
    $user->save();

    // Rediriger vers la page des utilisateurs correspondante
    return redirect()->route($redirect);
}

public function unblockNousUser($id, $redirect)
{
    // Récupérer l'utilisateur à débloquer
    $user = User::find($id);

    // Vérifier si l'utilisateur en question est l'administrateur lui-même
    if ($user->role === 'admin') {
        return redirect()->route($redirect)->withErrors(['error' => 'Vous ne pouvez pas débloquer l\'administrateur.']);
    }

    // Rediriger si l'utilisateur n'a pas le rôle "nous"
    if ($user->role !== 'nous') {
        return redirect()->route($redirect)->withErrors(['error' => 'Cet utilisateur n\'a pas le rôle "nous".']);
    }

    // Changer le statut de l'utilisateur à actif
    $user->active = true;

    // Si la colonne activated_at est nulle, mettre à jour avec la date actuelle
    if (is_null($user->activated_at)) {
        $user->activated_at = now();
    }

    // Sauvegarder les modifications
    $user->save();

    // Rediriger vers la page des utilisateurs correspondante
    return redirect()->route($redirect);
}

}
