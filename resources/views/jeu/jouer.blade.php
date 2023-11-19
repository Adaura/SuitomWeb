{{-- resources/views/jeu/jouer.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    td{
        height: 3.5em !important;
        width: 3.5em !important;
        padding: 1em;
        text-align: center;
        font-size: 20px;
        font-weight: bold
    }
</style>
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <table id="table" class="table-bordered border-3">
        <tr>
        <tr>
            <td>{{$mot->mot[0]}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tr>
    </table>

    <form style="display: none" action="{{ route('jeu.verifier', $jour) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mot">Votre essai:</label>
            <input type="text" name="mot" id="mot" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Valider</button>
    </form>
</div>
<script>
    const theword = "{{$mot->mot}}";
    let words = [], word = theword.slice(0, 1)
    console.log(theword);
    document.onkeypress = function (e) {
        if (word.length === theword.length) {
        } else {
            const col = (words.length * theword.length) + word.length
            if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122)) {
                word += e.key
                document.getElementsByTagName('td')[col].innerHTML = e.key.toUpperCase()
            }
        }
    };
    document.onkeydown = (e) => {
        const col = (words.length * theword.length) + word.length
        if (e.keyCode === 13 && word.length === theword.length) {
            words.push(word);
            if(word.toUpperCase() === theword.toUpperCase()){
                document.getElementById('mot').value = theword;
                document.forms[0].submit();
            }
            word = theword.slice(0, 1);
            document.getElementsByTagName('td')[col].innerHTML = word;
        }
        if (e.keyCode === 8 && word.length > 1) {
            word = word.slice(0, -1);
            document.getElementsByTagName('td')[col - 1].innerHTML = '';
        }

    }
</script>
@endsection