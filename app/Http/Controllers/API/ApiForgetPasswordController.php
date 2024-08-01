<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ApiForgetPasswordController extends Controller
{
  // Afficher la page de demande de réinitialisation du mot de passe
  public function forgetpassword()
  {
      return response()->json(['message' => 'Veuillez fournir votre numéro pour réinitialiser le mot de passe.'], 200);
  }

  // Vérifier le numéro
  public function checknumber(Request $request)
  {
      $numero = $request->input('numero');
      $user = User::where('numero', $numero)->first();

      if ($user) {
          return response()->json(['message' => 'Numéro trouvé, veuillez fournir les informations nécessaires pour réinitialiser le mot de passe.', 'numero' => $numero], 200);
      } else {
          return response()->json(['error' => 'Compte introuvable.'], 404);
      }
  }

  // Afficher le quiz pour la réinitialisation du mot de passe
  public function showQuiz($numero)
  {
      // Assurez-vous que cette méthode correspond à vos besoins API, sinon adaptez-la.
      return response()->json(['message' => 'Veuillez répondre aux questions de sécurité pour réinitialiser votre mot de passe.', 'numero' => $numero], 200);
  }

  // Vérifier les informations fournies
  public function verifyInformation(Request $request)
  {
      $numero = $request->input('numero');
      $name = $request->input('name');
      $pseudo = $request->input('pseudo');

      $user = User::where('numero', $numero)->first();

      if ($user && strcasecmp($user->name, $name) === 0 && $user->pseudo === $pseudo) {
          return response()->json(['message' => 'Informations vérifiées, vous pouvez maintenant réinitialiser votre mot de passe.', 'id' => $user->id], 200);
      } else {
          return response()->json(['error' => 'Informations incorrectes.'], 400);
      }
  }

  // Afficher le formulaire de réinitialisation du mot de passe
  public function showResetForm($id)
  {
      // Cette méthode devrait être adaptée pour renvoyer un message JSON, si nécessaire
      return response()->json(['message' => 'Veuillez fournir un nouveau mot de passe.'], 200);
  }

  // Réinitialiser le mot de passe
  public function resetPassword(Request $request)
  {
      $request->validate([
          'id' => 'required|exists:users,id',
          'password' => 'required|string|min:8|confirmed',
      ]);

      $user = User::find($request->id);

      if ($user) {
          $user->password = Hash::make($request->password);
          $user->save();

          return response()->json(['message' => 'Mot de passe réinitialisé avec succès.'], 200);
      } else {
          return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
      }
  }}
