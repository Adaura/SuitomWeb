<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;


use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    function __invoke()
    {
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'mot_id' => 'required|exists:mots,id',
            'commentaire' => 'required|string',
        ]);

        $commentaire = new Commentaire();
        $commentaire->user_id = auth()->id();
        $commentaire->mot_id = $request->mot_id;
        $commentaire->commentaire = $request->commentaire;
        $commentaire->save();

        return back()->with('success', 'Votre commentaire a été ajouté.');
    }

    public function show($id)
    {
        $mot = Mot::with('commentaires.user')->findOrFail($id);

        return view('nom_de_la_vue_mot', ['mot' => $mot]);
    }
}
