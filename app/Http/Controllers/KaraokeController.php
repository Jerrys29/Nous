<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assurez-vous d'importer le modèle User

class KaraokeController extends Controller
{
    public function register(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'name' => 'required|string',
            'mdp' => 'required|string',
            'phone_number' => 'required|string',
            'pseudo' => 'required|string',
            'birthdate' => 'required|date',
            'birthplace' => 'required|string',
            'origin_country' => 'required|string',
        ]);

        // Créez un nouvel utilisateur avec le rôle 'karaoke' et les données du formulaire
        $user = User::create($request->all() + ['role' => 'karaoke']);

        // Redirigez ou effectuez d'autres actions après l'enregistrement

        return redirect()->route('nom_de_la_route_vers_page_de_succes');
    }
}
