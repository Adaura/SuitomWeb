<?php

namespace App\Http\Controllers;

use App\Models\Mot;
use Illuminate\Http\Request;

class JeuController extends Controller
{
    public $word = "boom";
    public function index()
    {
        // Créer un tableau des jours du mois actuel
        $jours = range(1, now()->daysInMonth);

        return view('jeu.index', ['jours' => $jours]);
    }

    public function jouer()
    {
        $mot = $this->getMotDuJour();
        if(!$mot){
            $mot = new Mot();
            $faker = \Faker\Factory::create('fr_FR');
            $mot->mot = $faker->word; // génère un mot aléatoire
            $mot->date = now();
            $mot->save();
        }

        return view('jeu.jouer', ['mot' => $mot, 'word' => $this->word]);
    }


    public function verifier(Request $request)
    {
        $mot = $this->getMotDuJour();
        if ($request->input('mot') == $mot->mot) {
            return redirect()->route('jeu.jouer')->with('success', 'Bravo! Vous avez deviné le mot correctement.');
        } else {
            return redirect()->route('jeu.jouer')->with('error', 'Essayez encore.');
        }
    }

    private function getMotDuJour()
    {
        return Mot::whereDay('date', now()->day)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->first();
    }

    public function set()
    {
        $this->word = "";
    }
}
