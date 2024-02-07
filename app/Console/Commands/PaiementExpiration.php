<?php

namespace App\Console\Commands;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PaiementExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paiement:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    
    public function handle()
    {
        $expirationDate = Carbon::now()->subMonth(); // Date d'expiration (un mois plus tôt)
    
        // Récupérer tous les utilisateurs dont la date de paiement est expirée
        $usersToUpdate = User::where('paiement', 1)
                              ->where('paiement_date', '<=', $expirationDate)
                              ->get();
    
        // Mettre à jour le paiement à 0 pour les utilisateurs concernés
        foreach ($usersToUpdate as $user) {
            $user->update(['paiement' => 0]);
        }
    }
    
}
