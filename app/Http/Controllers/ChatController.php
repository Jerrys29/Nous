<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Reponse;
use Google\Protobuf\Internal\Message;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class ChatController extends Controller
{
    public function send(Request $request)
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
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string',
            'numero' => 'required|string',
        ]);
    
        // Vérifier si l'utilisateur existe dans la base de données
        $utilisateur = Discussion::where('name_sender', $request->input('name'))
            ->where('numero', $request->input('numero'))
            ->first();
    
        if ($utilisateur) {
            // Récupérer les messages de l'utilisateur
            $messagesUtilisateur = Discussion::where('name_sender', $utilisateur->name)
                ->where('numero', $utilisateur->numero)
                ->orderBy('created_at', 'asc')
                ->get();
    
            // Récupérer les réponses associées à ces messages
            $messagesAvecReponses = collect();
    
            foreach ($messagesUtilisateur as $message) {
                $reponsesModerateur = Reponse::where('id_discussion', $message->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
                // Ajouter le message de l'utilisateur et les réponses du modérateur à la collection
                $messagesAvecReponses->push($message);
                $messagesAvecReponses = $messagesAvecReponses->merge($reponsesModerateur);
            }
    
            // Retourner une réponse JSON avec les messages de l'utilisateur et les réponses du modérateur
            return response()->json(['messages' => $messagesAvecReponses]);
        } else {
            // Retourner une réponse JSON avec les champs name et numero
            return response()->json([
                'name' => $request->input('name'),
                'numero' => $request->input('numero'),
            ]);
        }
        
    }
    

    public function envoyerMessage(Request $request)
    {
        // Validation des données
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $message = new Reponse();
        $message->contenu = $request->input('contenu');
        $message->id_discussion = $request->input('id_discussion');

        $message->save();

        // Redirection vers la page précédente (ou la même page)
        return redirect()->back();
    }


    public function getNewMessages($lastMessageId)
    {
        $newMessages = Reponse::where('id', '>', $lastMessageId)->orderBy('id')->get();

        return response()->json(['newMessages' => $newMessages]);
    }

    public function view()
    {
        $derniersMessages = Discussion::select('discussions.name_sender', 'discussions.message', 'discussions.numero')
            ->leftJoin('discussions as d2', function ($join) {
                $join->on('discussions.name_sender', '=', 'd2.name_sender')
                    ->on('discussions.numero', '=', 'd2.numero')
                    ->whereRaw('discussions.id < d2.id');
            })
            ->whereNull('d2.id')
            ->get();

        return view('Admin.messages', compact('derniersMessages'));
    }

    public function viewDetail($namesender, $numero)
    {
        $userMessages = Discussion::where('name_sender', $namesender)
            ->where('numero', $numero)
            ->get();

        $dernierMessage = Discussion::where('name_sender', $namesender)
            ->where('numero', $numero)
            ->latest()
            ->first();

        $moderatorResponses = Reponse::whereIn('id_discussion', $userMessages->pluck('id'))->get();
        $allMessages = $userMessages->merge($moderatorResponses);
        $sortedMessages = $allMessages->sortBy('created_at');
        return view('Admin.detailmessage', compact('sortedMessages', 'dernierMessage'));
    }
}
