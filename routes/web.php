<?php

use App\Http\Controllers\IdeaController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [IdeaController::class, 'index']);
    Route::get('/idea-submit', [IdeaController::class, 'create'])->name('idea.index');
    Route::post('/idea-submit', [IdeaController::class, 'store'])->name('idea.store');
    Route::get('/current-tournaments', [IdeaController::class, 'currentTournaments']);
});

require __DIR__ . '/auth.php';
