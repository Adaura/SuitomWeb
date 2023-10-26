{{-- resources/views/jeu/jouer.blade.php --}}
@extends('layouts.app')

@section('content')
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

    <form action="{{ route('jeu.verifier', $jour) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mot">Votre essai:</label>
            <input type="text" name="mot" id="mot" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Valider</button>
    </form>
</div>
@endsection

