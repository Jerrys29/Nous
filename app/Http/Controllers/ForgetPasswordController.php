<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Paiements;
use Illuminate\Support\Facades\Hash; // Assurez-vous d'importer la classe Hash
use Illuminate\Validation\Rule; // Assurez-vous d'importer la classe Rule pour la validation


class ForgetPasswordController extends Controller
{
    public function forgetpassword(){
        return view('forgotpassword/number');
    }


    public function checknumber(Request $request){
        // Get le numéro envoyé par le formulaire
        $numero = $request->input('numero');
    
        // Récupérer l'utilisateur correspondant au numéro
        $user = User::where('numero', $numero)->first();
    
        if($user){
            // Rediriger vers une méthode du contrôleur avec les paramètres
            return redirect()->route('quiz.show', ['numero' => $numero]);
        }
        else{
            return redirect()->route('connection')->with('error', 'Compte introuvable.');
        }
    }

    public function showQuiz($numero) {
        return view('forgotpassword/quizreset', compact('numero'));

    }
    
    public function verifyInformation(Request $request) {
        $numero = $request->input('numero');
        $name = $request->input('name');
        $pseudo = $request->input('pseudo');
    
        $user = User::where('numero', $numero)->first();
    
        if ($user && strcasecmp($user->name, $name) === 0 && $user->pseudo === $pseudo) {
            return redirect()->route('password.reset', ['id' => $user->id]);
        } else {
            return redirect()->route('quiz.show', ['numero' => $numero, 'role' => $user->role])->with('error', 'Informations incorrectes.');
        }
    }
    

    public function showResetForm($id) {
        return view('forgotpassword.reset', ['id' => $id]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::find($request->id);
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
    
            return redirect()->route('connection')->with('success', 'Mot de passe réinitialisé avec succès.');
        } else {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
    }
    
}

