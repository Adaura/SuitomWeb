{{-- resources/views/jeu/jouer.blade.php --}}
@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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
<div class="container col-lg-8 d-flex justify-content-center flex-column p-5">

  <!-- Button trigger modal -->
  <div class="d-flex justify-content-center ms-auto mb-3">
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Statistiques
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="18"
        height="18" viewBox="0 0 256 256" xml:space="preserve">
        <defs>
        </defs>
        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
          transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
          <path
            d="M 45 2 c 3.004 0 6.001 0.314 8.934 0.935 l -14.021 41.5 l -0.233 0.69 l 0.265 0.678 l 15.957 40.798 C 52.353 87.53 48.696 88 45 88 C 21.29 88 2 68.71 2 45 S 21.29 2 45 2 M 45 0 C 20.147 0 0 20.147 0 45 c 0 24.853 20.147 45 45 45 c 4.727 0 9.283 -0.733 13.563 -2.085 l -16.755 -42.84 L 56.531 1.497 C 52.85 0.524 48.987 0 45 0 L 45 0 z"
            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
          <path d="M 86.934 28.656 c -4.452 -11.41 -13.425 -20.558 -24.72 -25.239 L 49.59 40.788 L 86.934 28.656 z"
            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
          <path
            d="M 87.245 36.967 C 87.747 39.612 88 42.306 88 45 c 0 15.856 -8.876 30.524 -22.787 37.954 L 51.739 48.501 L 87.245 36.967 M 88.733 34.38 l -39.63 12.874 L 64.15 85.725 C 79.424 78.53 90 63.003 90 45 C 90 41.341 89.558 37.786 88.733 34.38 L 88.733 34.38 z"
            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
            transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
        </g>
      </svg>
    </button>
  </div>

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
  <table id="table" class="table-bordered border-3 rounded">
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

  {{-- ... --}}

  <form method="POST" class="d-flex py-3 justify-content-end" action="{{ route('mot.like', $mot->id) }}">
    @csrf
    <button type="submit"
      class="btn btn-{{ $mot->likes->where('user_id', Auth::id())->count() > 0 ? 'secondary' : 'primary' }}">
      {{ $mot->likes->where('user_id', Auth::id())->count() > 0 ? 'Unlike' : 'Like' }}
    </button>
  </form>

  <p>{{ $mot->likes->count() }} likes</p>

  {{-- ... --}}


  <div class="my-5 container ms-auto d-flex flex-column align-items-end">
    <form class="col-8" method="POST" action="{{ route('commentaire.store') }}">
      <h5>Commentaires</h5>
      @for ($i = 0; isset($comments[$i]); $i++)
      <div class="py-1 my-2 col-6 card p-3">
        <div class="d-flex align-items-center">
          <span title="{{$comments[$i]->user->name}}"
            class="bg-dark rounded-circle d-flex justify-content-center align-items-center font-weight-bold"
            style="width: 35px; height: 35px; font-size:20px"><b
              class="text-white p-3 ">{{strtoupper($comments[$i]->user->name[0])}}</b></span>
          <p class="m-3">{{$comments[$i]->commentaire}}</p>
        </div>
        <p style="text-align: right" class="mb-0">{{$comments[$i]->created_at}}</p>
      </div>
      @endfor
      @csrf
      <input type="hidden" name="mot_id" value="{{ $mot->id }}">
      <div class="form-group my-3">
        <div class="row align-items-end">
          <div class="col-10">
            <textarea onfocus="comment = true" onfocusout="comment = false" name="commentaire"
              placeholder="Partager votre expérience avec les autres joueurs" class="form-control"></textarea>
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-dark">Poster</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Statistique des tentatives</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const guessedLetters = [], words = {!! isset($words) ? $words : '[]'!!}, wordSize = {{ strlen($mot -> mot) }};
  let word = "{{ $mot-> mot[0]}}", comment = false;
  document.onkeypress = function (e) {
    if (!comment) {
      if (word.length !== wordSize) {
        const col = (words.length * wordSize) + word.length
        if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122)) {
          word += e.key
          document.getElementsByTagName('td')[col].innerHTML = e.key.toUpperCase()
        }
      }
    }
  };
  document.onkeydown = (e) => {
    if (!comment) {
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

  }
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Réussite', 'Echec'],
      datasets: [{
        label: 'Nombre de tentatives',
        data: [{{ $mot-> success}}, {{ $mot-> failure}}],
    backgroundColor: ['#90f300', 'lightgrey'],
    borderWidth: 1
          }]
        }
      });
</script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
  integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>