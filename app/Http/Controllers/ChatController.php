<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;

class ChatController extends Controller
{
  
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'message' => 'required|string',
            'name' => 'required|string',
            'numero' => 'required|string',
        ]);
    
        // Enregistrer le message dans la base de données
        $discussion = new Discussion();
        $discussion->message = $request->input('message');
        $discussion->name_sender = $request->input('name');
        $discussion->numero = $request->input('numero');
        $discussion->save();
    
        // Répondre avec un message de succès
        return response()->json(['message' => $discussion->message]);
    }

    public function view()
    {
        $messages = Discussion::all();
        return view('Admin.messages', compact('messages'));
    }
    
    public function detail()
    {
        $messages = Discussion::all();
        return view('Admin.detailmessage', compact('messages'));
    }
}
