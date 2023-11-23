{{-- resources/views/jeu/jouer.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    td {
        height: 3.5em !important;
        width: 3.5em !important;
        padding: 1em;
        text-align: center;
        font-size: 20px;
        font-weight: bold
    }
</style>
<div class="container justify-content-center p-5">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(!session('success'))
    <table id="table" class="table-bordered border-3 table-info">
        @for ($i = 0; $i < 6; $i++) <tr>
            @for ($j = 0; $j < strlen($mot->mot); $j++)
                <td style="background: {{isset($indices[$i]) ? $indices[$i][$j]['color'] : ''}}">
                    @if($i == 0 && $j == 0)
                    {{strtoupper($mot->mot[0])}}
                    @elseif(isset($indices[$i]))
                    {{strtoupper($indices[$i][$j]['letter'])}}
                    @else
                    {{isset($indices[$i-1]) && $j == 0 ? strtoupper($mot->mot[0]) : ''}}
                    @endif
                </td>
                @endfor
                </tr>
                @endfor
    </table>
    <form method="POST" action="{{ route('mots.like', $mot->id) }}">
    @csrf
    <button type="submit" class="btn btn-{{ $mot->likes->where('user_id', Auth::id())->count() > 0 ? 'secondary' : 'primary' }}">
        {{ $mot->likes->where('user_id', Auth::id())->count() > 0 ? 'Unlike' : 'Like' }}
    </button>
</form>

<p>{{ $mot->likes->count() }} likes</p>
    <div class="">
        <div class="card">


            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <p>Ce mot a été deviné correctement {{ $mot->success_count }} fois.</p>
            </div>
        </div>
    </div>
    <div class="card">
    <div class="card-body">
        
        <form method="POST" action="{{ route('commentaire.store') }}">
            @csrf
            <input type="hidden" name="mot_id" value="{{ $mot->id }}">
            <textarea name="commentaire" required></textarea>
            <button type="submit">Poster le commentaire</button>
        </form>
    </div></div>


@foreach ($mot->commentaires as $commentaire)
    <div class="card mb-2">
        <div class="card-header">
            Commenté par {{ $commentaire->user->name }} le {{ $commentaire->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="card-body">
            <p>{{ $commentaire->commentaire }}</p>
        </div>
    </div>
@endforeach










    <form id="gameForm" style="display: none" action="{{ route('jeu.verifier', $jour) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mot">Votre essai:</label>
            <input type="text" name="mot" id="mot" class="form-control" required>
        </div>
        <input type="hidden" name="words" id="words">
        <button type="submit" class="btn btn-success">Valider</button>
    </form>
    @endif
</div>
<script>
    const guessedLetters = [], words = {!! isset($words) ? $words : '[]'!!}, wordSize = {{ strlen($mot -> mot) }};
    let word = "{{ $mot-> mot[0]}}"
    document.onkeypress = function (e) {
        if (word.length === wordSize) {
        } else {
            const col = (words.length * wordSize) + word.length
            if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122)) {
                word += e.key
                document.getElementsByTagName('td')[col].innerHTML = e.key.toUpperCase()
            }
        }
    };
    document.onkeydown = (e) => {
        const col = (words.length * wordSize) + word.length
        if (e.keyCode === 13 && word.length === wordSize) {
            words.push(word);
            document.getElementById('words').value = JSON.stringify(words);
            document.getElementById("gameForm").submit();
        }
        if (e.keyCode === 8 && word.length > 1) {
            word = word.slice(0, -1);
            document.getElementsByTagName('td')[col - 1].innerHTML = '';
        }

    }
</script>
@endsection