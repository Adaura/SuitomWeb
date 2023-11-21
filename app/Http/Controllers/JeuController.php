<?php

namespace App\Http\Controllers;

use App\Models\Mot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JeuController extends Controller
{
    public $word = "boom";
    public function index()
    {
        // Créer un tableau des jours du mois actuel
        $jours = range(1, now()->daysInMonth);

        return view('jeu.index', ['jours' => $jours]);
    }

    public function jouer($jour)
    {
        if (!Auth::user()) {
            return view('auth.login');
        }
        $mot = $this->getMotDuJour($jour);
        if (!$mot) {
            $mot = new Mot();
            $faker = \Faker\Factory::create('fr_FR');
            $mot->mot = $faker->word; // génère un mot aléatoire
            $mot->date = now()->startOfMonth()->addDays($jour - 1);
            $mot->save();
        }

        return view('jeu.jouer', ['mot' => $mot, 'jour' => $jour]);
    }


    public function verifier(Request $request, $jour)
    {
        $mot = $this->getMotDuJour($jour);
        $motDuJour = strtolower($mot->mot);
        $hintTab = [];
        $words = json_decode($request->input('words'));
        foreach ($words as $val) {
            $val = strtolower($val);
            $hints = [];
            if ($val == $motDuJour) {
                return redirect()->route('jeu.jouer', ['jour' => $jour])->with('success', 'Bravo! Vous avez deviné le mot correctement.');
            } else {
                for ($i = 0; isset($motDuJour[$i]); $i++) {
                    $letter = $val[$i];
                    if ($motDuJour[$i] == $letter) {
                        $color = 'red';
                    } else {
                        $color = str_contains($motDuJour, $letter) ? 'yellow' : 'none';
                    }
                    $hints[] = [
                        'letter' => $letter,
                        'color' => $color
                    ];
                }
                $hintTab[] = $hints;
            }
        }
        return view(
            'jeu.jouer',
            [
                'mot' => $mot,
                'jour' => $jour,
                'indices' => $hintTab,
                'words' => $request->input('words')
            ]
        )->with(
                'error',
                'Essayez encore.'
            );
    }

    private function getMotDuJour($jour)
    {
        return Mot::whereDay('date', $jour)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->first();
    }
}
