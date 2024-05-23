<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function forgetpassword(Request $request){
        return view('forgotpassword/number');
    }
    public function checknumber(){
      // get le number envoyé par le formulaire
        $numeronumero = $request-> input('numero');

        $user= User::where('numero', $numero)->first();

        if($user){
            return view ('forgotpassword/quizrest');
        }
    }
}
