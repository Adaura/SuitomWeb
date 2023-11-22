<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\JeuController;
use App\Http\Controllers\Auth\RegisterController; 
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/accueil', [HomeController::class, 'index'])->name('accueil');
Route::get('/game', [GameController::class, 'index'])->name('game');
Route::get('/jeu', [JeuController::class, 'index'])->name('jeu.index');
Route::get('/jeu/jouer/{jour}', [JeuController::class, 'jouer'])->name('jeu.jouer');
Route::post('/jeu/verifier/{jour}', [JeuController::class, 'verifier'])->name('jeu.verifier');


Route::get('/change-name', [RegisterController::class, 'showChangeNameForm'])->name('name.change-form')->middleware('auth');
Route::post('/change-name', [RegisterController::class, 'changeName'])->name('name.change')->middleware('auth');
