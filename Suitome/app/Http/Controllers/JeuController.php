<?php

namespace App\Http\Controllers;

use App\Models\Mot;
use Illuminate\Http\Request;

class JeuController extends Controller
{
    public function index()
    {
        // Créer un tableau des jours du mois actuel
        $jours = range(1, now()->daysInMonth);

        return view('jeu.index', ['jours' => $jours]);
    }

    public function jouer($jour)
    {
        $mot = $this->getMotDuJour($jour);

        if (!$mot) {
            return redirect()->route('jeu.index')->with('error', 'Jeu non disponible pour ce jour.');
        }

        return view('jeu.jouer', ['mot' => $mot, 'jour' => $jour]);
    }


    public function verifier(Request $request, $jour)
    {
        $mot = $this->getMotDuJour($jour);

        if (!$mot) {
            return redirect()->route('jeu.index')->with('error', 'Jeu non disponible pour ce jour.');
        }

        if ($request->input('mot') == $mot->mot) {
            return redirect()->route('jeu.jouer', ['jour' => $jour])->with('success', 'Bravo! Vous avez deviné le mot correctement.');
        } else {
            return redirect()->route('jeu.jouer', ['jour' => $jour])->with('error', 'Essayez encore.');
        }
    }

    private function getMotDuJour($jour)
    {
        return Mot::whereDay('date', $jour)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->first();
    }
}
