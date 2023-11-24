{{-- resources/views/auth/change_name.blade.php --}}

@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<div class="container">
    <h1>Modifier le Profil</h1>
    <form method="POST" action="{{ route('name.change') }}" class="col-6">
        @csrf
        <div class="form-group">
            <label for="name">Nouveau nom </label>
            <input class="form-control mb-3" id="name" name="name" value="{{ old('name') ?? auth()->user()->name }}" required>
        </div>
        <button class="btn btn-success" type="submit">Mettre à jour</button>
    </form>
    
</div>
@endsection
