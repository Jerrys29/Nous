<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Paiements;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ForgetPasswordController extends Controller
{
    public function forgetpassword()
    {
        return response()->json(['message' => 'Forget password page not implemented as JSON response.'], 501);
    }

    public function checknumber(Request $request)
    {
        $numero = $request->input('numero');

        $user = User::where('numero', $numero)->first();

        if ($user) {
            return response()->json(['message' => 'Number exists.', 'redirect' => route('quiz.show', ['numero' => $numero])], 200);
        } else {
            return response()->json(['error' => 'Compte introuvable.'], 404);
        }
    }

    public function showQuiz($numero)
    {
        return response()->json(['numero' => $numero], 200);
    }

    public function verifyInformation(Request $request)
    {
        $numero = $request->input('numero');
        $name = $request->input('name');
        $pseudo = $request->input('pseudo');

        $user = User::where('numero', $numero)->first();

        if ($user && strcasecmp($user->name, $name) === 0 && $user->pseudo === $pseudo) {
            return response()->json(['message' => 'Informations correctes.', 'redirect' => route('password.reset', ['id' => $user->id])], 200);
        } else {
            return response()->json(['error' => 'Informations incorrectes.'], 400);
        }
    }

    public function showResetForm($id)
    {
        return response()->json(['id' => $id], 200);
    }

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
    }
}
