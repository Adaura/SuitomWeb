<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\JeuController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\MotLikeController;


// ...



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
Route::get('/jeu', [JeuController::class, 'index'])->name('jeu.index');
Route::get('/jeu/jouer/{jour}', [JeuController::class, 'jouer'])->name('jeu.jouer');
Route::post('/jeu/verifier/{jour}', [JeuController::class, 'verifier'])->name('jeu.verifier');


Route::get('/change-name', [UserController::class, 'edit'])->name('name.change-form');
Route::post('/change-name', [UserController::class, 'editUser'])->name('name.change');

Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaire.store');

Route::post('/mots', [MotLikeController::class, 'like'])->name('mots.like');

Route::post('/mots/{mot}/like', [MotLikeController::class, 'like'])->name('mots.like');

