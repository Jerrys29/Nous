<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Reponse;
use Google\Protobuf\Internal\Message;
use Illuminate\Support\Facades\DB;

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
        $derniersMessages = Discussion::select('name_sender', 'message')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('discussions')
                    ->groupBy('numero', 'name_sender');
            })
            ->get();  
        return view('Admin.messages', compact('derniersMessages'));
    }

    public function detail()
    {
        $messages = Discussion::all();
        return view('Admin.detailmessage', compact('messages'));
    }

    public function viewDetail($namesender, $numero)
    {
        $userMessages = Discussion::where('name_sender', $namesender)
            ->where('numero', $numero)
            ->get();
        $moderatorResponses = Reponse::whereIn('id_discussion', $userMessages->pluck('id'))->get();
        $allMessages = $userMessages->merge($moderatorResponses);
        $sortedMessages = $allMessages->sortBy('created_at');

        return view('Admin.detail', compact('sortedMessages'));
    }
}
