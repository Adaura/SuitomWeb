@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="">
            <div class="card">
                <div class="card-header bg-white">
                    <h3>Sutom </h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <p>Règles</p>
                    <p>Vous avez six essais pour deviner le mot du jour, entre 6 et 9 lettres, commun à tous.Vous ne pouvez proposer que des mots commençant par la même lettre que le mot recherché, et qui se trouvent dans notre dictionnaire.Les noms propres ne sont pas acceptés.</p>
                    <p>Le mot change chaque jour. Évitez donc les spoils et privilégiez le bouton de partage.</p>

                    <p>S A L U T</p>

                    <p>Les lettres entourées d'un carré rouge sont bien placées,les lettres entourées d'un cercle jaune sont mal placées (mais présentes dans le mot).Les lettres qui restent sur fond bleu ne sont pas dans le mot.En cas de soucis, vous pouvez contacter @Jonamaths sur twitter ou @JonathanMM@mastodon.social sur mastodon. Page du projet</p>
                    <p>Basé sur l'excellent Wordle et le regretté Motus.</p>
                    <p>Merci à Emmanuel pour l'aide sur les mots à trouver, et à GaranceAmarante pour l'aide sur le dictionnaire.</p>
                    <p>Les icônes proviennent de Material Design</p>
                </div>
            </div>
        </div>

        <footer></footer>
        <div class="">
            <div class="card">
                <div class="card-header bg-white">Contacter Sutom</div>

                <div class="card-body">

                    © 2023 Agora Francia. Tous droits réservés.<br /><br />

                    Agora Francia est une plateforme d'achat en ligne inspirée du marché grec antique, permettant une variété de transactions entre clients et vendeurs. Nos services incluent la vente immédiate, la vente par négociation et la vente par meilleure offre.<br />

                    Le site est géré par une équipe d'administrateurs qui supervisent l'ajout et la suppression de comptes vendeurs. <br />
                    <br />

                    Numero de téléphone :<br /><br />

                    066666666
                </div>
            </div>
        </div>
        </footer>
    </div>
</div>
@endsection