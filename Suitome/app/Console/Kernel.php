<?php


namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Mot;



class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Générer un mot pour chaque jour du mois
            $joursDuMois = now()->daysInMonth;
            $faker = \Faker\Factory::create('fr_FR'); // pour des mots en français

            for ($i = 1; $i <= $joursDuMois; $i++) {
                $mot = new Mot();
                $mot->contenu = $faker->word; // génère un mot aléatoire
                $mot->created_at = now()->startOfMonth()->addDays($i - 1);
                $mot->save();
            }
        })->monthlyOn(1, '00:00'); // exécute cette tâche le premier jour de chaque mois à minuit
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
