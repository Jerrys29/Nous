<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{
    // Affiche le formulaire pour demander un mot de passe oublié
    public function forgetpassword()
    {
        return response()->json(['message' => 'Veuillez fournir votre numéro de téléphone.'], 200);
    }

    // Vérifie le numéro et renvoie un token ou une erreur
    public function checknumber(Request $request)
    {
        $request->validate([
            'numero' => 'required|string'
        ]);

        $numero = $request->input('numero');
        $user = User::where('numero', $numero)->first();

        if ($user) {
            // Générer un token ou envoyer un lien de réinitialisation
            // Pour l'exemple, nous retournons simplement un message de succès
            return response()->json(['message' => 'Utilisateur trouvé.', 'user_id' => $user->id], 200);
        } else {
            return response()->json(['error' => 'Compte introuvable.'], 404);
        }
    }

    // Affiche le quiz pour vérifier les informations
    public function showQuiz($numero)
    {
        return response()->json(['message' => 'Veuillez fournir les informations de vérification.'], 200);
    }

    // Vérifie les informations fournies et renvoie un message ou une erreur
    public function verifyInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|string',
            'name' => 'required|string',
            'pseudo' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $numero = $request->input('numero');
        $name = $request->input('name');
        $pseudo = $request->input('pseudo');

        $user = User::where('numero', $numero)->first();

        if ($user && strcasecmp($user->name, $name) === 0 && $user->pseudo === $pseudo) {
            return response()->json(['message' => 'Informations vérifiées avec succès.', 'user_id' => $user->id], 200);
        } else {
            return response()->json(['error' => 'Informations incorrectes.'], 400);
        }
    }

    // Affiche le formulaire pour réinitialiser le mot de passe
    public function showResetForm($id)
    {
        return response()->json(['message' => 'Veuillez fournir un nouveau mot de passe.'], 200);
    }

    // Réinitialise le mot de passe et renvoie un message de succès ou une erreur
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::find($request->id);
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['message' => 'Mot de passe réinitialisé avec succès.'], 200);
        } else {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }
    }
}
