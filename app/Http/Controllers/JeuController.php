<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\User;
use App\Models\Essai;
use App\Models\Mot;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JeuController extends Controller
{
    private $essais;

    public function index()
    {
        // Créer un tableau des jours du mois actuel
        $jours = range(1, now()->daysInMonth);

        return view('jeu.index', ['jours' => $jours]);
    }

    public function jouer($jour, Request $request)
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
        $this->loadComments($mot->id);
        $essai = $this->getAttempts($mot->id, $request->input('words'));
        $hintTabs = $this->getHints(json_decode($essai->tentative), $mot->mot, $jour);
        return view(
            'jeu.jouer',
            [
                'mot' => $mot,
                'jour' => $jour,
                'words' => $essai->tentative,
                'indices' => $hintTabs,
                'comments' => $this->loadComments($mot->id)
            ]
        );
    }


    public function verifier(Request $request, $jour)
    {
        $mot = $this->getMotDuJour($jour);
        $motDuJour = strtolower($mot->mot);
        $hintTab = [];
        $words = json_decode($request->input('words'));
        $essai = $this->getAttempts($mot->id, $request->input('words'));
        $essai->save();
        foreach ($words as $val) {
            $val = strtolower($val);
            $hints = [];
            if ($val == $motDuJour) {
                $mot->success++;
                $mot->save();
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
        $mot->failure++;
        $mot->save();
        $this->loadComments($mot->id);
        return view(
            'jeu.jouer',
            [
                'mot' => $mot,
                'jour' => $jour,
                'indices' => $hintTab,
                'words' => $request->input('words'),
                'comments' => $this->loadComments($mot->id)
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

    private function getAttempts($motId, $attempts)
    {
        $essai = Essai::query()
            ->where('user_id', Auth::user()->id)
            ->where('mot_id', $motId)
            ->get()->first();
        if (!$essai) {
            $essai = new Essai();
            $essai->mot_id = $motId;
            $essai->user_id = Auth::user()->id;
        }
        if ($attempts) {
            $essai->tentative = $attempts;
        }
        return $essai;
    }

    function getHints($words, $motDuJour, $jour)
    {
        if (!$words) {
            return [];
        }
        $hintTab = [];
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
        return $hintTab;
    }

    private function loadComments($motId)
    {
        $comments = [];
        foreach (Commentaire::where('mot_id', $motId)->get() as $value) {
            $value -> user = User::where("id", $value->user_id)->first();
            $comments[] = $value;
        }
        return $comments;
    }
}
