{{-- resources/views/jeu.blade.php --}}

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
    <div class="card">
        <div class="card-body">
            <h1>Choisissez un jour pour jouer!</h1>
            <div class="row">
                @foreach($jours as $jour)
                <div class="col-md-2">
                    @if($jour <= now()->day)
                        <a href="{{ route('jeu.jouer', $jour) }}" class="btn calendar-btn m-2 {{$jour == now()->day+1 ? 'btn-light' : ''}}">{{ $jour }}</a>
                        @else
                        <span class="btn m-2 text-secondary">{{ $jour }}</span>
                        @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection