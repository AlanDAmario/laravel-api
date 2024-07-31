<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/', function () {
//     return view('guest.welcome');
// });
Route::get('/', function () {
    return view('guest.welcome');
});



//VANTAGGI DI UNA DASHBOARD:

//Organizzazione e Pulizia del Codice:
// Separare la logica della dashboard in un controller dedicato ti aiuta a mantenere il codice organizzato. Questo rende il progetto più manutenibile e facilita l'aggiunta di nuove funzionalità specifiche per la dashboard.

// Sicurezza:
// Puoi facilmente applicare middleware di autenticazione per proteggere la dashboard e assicurarti che solo gli utenti autenticati possano accedervi.

// Scalabilità:
// Man mano che la tua applicazione cresce, è probabile che aggiungerai più funzionalità alla dashboard. Avere un controller separato rende più facile gestire queste nuove funzionalità senza incasinare altri controller.

// Gestione delle Rotte:
// Avere un controller specifico per la dashboard ti permette di gestire tutte le rotte relative alla dashboard in un unico posto, semplificando la navigazione e la manutenzione delle rotte.

Route::middleware('auth', 'verified')
    //name aggiunge un prefisso al nome delle nostre rotte, il punto serve a separare il nome della rotta
    ->name('admin.')
    //prefix permette di aggiungere un prefisso a tutte le rotte definite all'interno del gruppo. Questo significa che tutte le rotte nel gruppo condivideranno una parte comune dell'URL.
    ->prefix('admin')

    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('projects', ProjectController::class)->parameters(['projects' => 'project:slug']);
        Route::get('/welcome', [DashboardController::class, 'welcome'])->name('welcome');
    });




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
