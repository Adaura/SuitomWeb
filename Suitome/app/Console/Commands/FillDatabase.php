<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mot;

class FillDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill the database with random words for the current month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Supprimer tous les mots du mois en cours
        Mot::whereMonth('date', now()->month)->delete();
        // Générer un mot pour chaque jour du mois
        $joursDuMois = now()->daysInMonth;

        for ($i = 1; $i <= $joursDuMois; $i++) {
            $mot = $this->getRandomWordFromFile();

            // Si le mot contient un accent, passer à la prochaine itération de la boucle
            if (preg_match('/[àâäéèêëîïôöûüùç]/i', $mot)) {
                $i--;  // Décrémentez la variable pour ne pas sauter un jour
                continue;
            }

            $motEntry = new Mot();
            $motEntry->mot = $mot;
            $motEntry->date = now()->startOfMonth()->addDays($i - 1); // Ajout de la colonne date
            $motEntry->save();
        }

        $this->info('Database filled successfully!');
    }


    /**
     * Obtenir un mot aléatoire du fichier.
     *
     * @return string
     */
    protected function getRandomWordFromFile()
    {
        $path = storage_path('mots.txt'); // Chemin vers le fichier
        $mots = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Lire le fichier en tant que tableau

        return $mots[array_rand($mots)]; // Retourner un mot aléatoire
    }
}
