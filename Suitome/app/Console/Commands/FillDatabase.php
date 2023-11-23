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
       
        Mot::whereMonth('date', now()->month)->delete();
       
        $joursDuMois = now()->daysInMonth;

        for ($i = 1; $i <= $joursDuMois; $i++) {
            $mot = $this->getRandomWordFromFile();

            
            if (preg_match('/[àâäéèêëîïôöûüùç]/i', $mot)) {
                $i--;  
                continue;
            }

            $motEntry = new Mot();
            $motEntry->mot = $mot;
            $motEntry->date = now()->startOfMonth()->addDays($i - 1); 
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
        $path = storage_path('mots.txt'); 
        $mots = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 

        return $mots[array_rand($mots)]; 
    }
}
