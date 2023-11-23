{{-- resources/views/auth/change_name.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Profil</h1>
    <form method="POST" action="{{ route('name.change') }}">
        @csrf
        <div>
            <label for="name">Nouveau nom :</label>
            <input type="text" id="name" name="name" value="{{ old('name') ?? auth()->user()->name }}" required>
        </div>
        <button type="submit">Mettre à jour</button>
    </form>
    
</div>
@endsection
