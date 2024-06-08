<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\AuthController::class, 'index'])->name('auth.login');
Route::post('/log', [\App\Http\Controllers\AuthController::class, 'login'])->name('valide.login');
Route::get('/registre', [\App\Http\Controllers\AuthController::class, 'pageRegistre'])->name('page.registre');
Route::post('/registre', [\App\Http\Controllers\AuthController::class, 'registre'])->name('valide.registre');
Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/classement', [\App\Http\Controllers\ClassementController::class, 'index'])->name('classement.index');
    Route::get('/classement-etape/{id}', [\App\Http\Controllers\ClassementController::class, 'classementEtape'])->name('classement.etape');
    Route::post('/trie-general/', [\App\Http\Controllers\ClassementController::class, 'trieCategorie'])->name('trie.general');
    Route::get('/delete', [\App\Http\Controllers\ImportController::class, 'delete_all_table'])->name('d.all');
    Route::post('/trie-etape', [\App\Http\Controllers\ClassementController::class, 'trieEtape'])->name('trie.categorie');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/etape', [\App\Http\Controllers\EtapeController::class, 'etape'])->name('etape.liste');
    Route::get('/liste-courreur/{id}', [\App\Http\Controllers\EtapeController::class, 'getListeCourreurEtape'])->name('etape.liste-courreur');
    Route::post('/insert-time', [\App\Http\Controllers\CourseController::class, 'insert_time'])->name('insert.time');
    Route::get('/add-etape', [\App\Http\Controllers\EtapeController::class, 'addPage'])->name('add.etape');
    Route::post('/insert-etape', [\App\Http\Controllers\EtapeController::class, 'insertNewEtape'])->name('insert.etape');
    Route::post('/import', [\App\Http\Controllers\ImportController::class, 'etape'])->name('import.etape');
    Route::post('/import-point', [\App\Http\Controllers\ImportController::class, 'points'])->name('import.point');
    Route::get('/generate-categorie', [\App\Http\Controllers\CategorieController::class, 'generate'])->name('generate.categorie');
    Route::get('/liste-penalite', [\App\Http\Controllers\PenaliteController::class, 'index'])->name('liste.penalite');
    Route::get('/inserte-penalite', [\App\Http\Controllers\PenaliteController::class, 'page'])->name('page.penalite');
    Route::post('/inserte-p/', [\App\Http\Controllers\PenaliteController::class, 'insert_penaltie'])->name('insert.penalite');
    Route::post('/delete-penalite/', [\App\Http\Controllers\PenaliteController::class, 'delete_penalite'])->name('delete.penalite');
    Route::get('/pdf-winner', [\App\Http\Controllers\PdfController::class, 'exportpdf'])->name('genarete.pdf');
    Route::get('/get-equipe-courreur/{id}', [\App\Http\Controllers\ClassementController::class, 'get_courreur_etape'])->name('equipe.c');

});

Route::middleware(['auth', 'role:equipe'])->group(function () {
    Route::get('/liste-etape', [\App\Http\Controllers\EtapeController::class, 'index'])->name('etape.index');
    Route::post('/insert-courreur', [\App\Http\Controllers\CourseController::class, 'insert_courreur'])->name('insert.courreur');
    Route::get('/chrono-courreur/{id}', [\App\Http\Controllers\EtapeController::class, 'courreur_chrono'])->name('courreur.chrono');


});


