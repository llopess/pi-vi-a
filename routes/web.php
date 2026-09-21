<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Publico\AcompanhamentoController;
use App\Http\Controllers\Publico\CatalogoController;
use App\Http\Controllers\Publico\PaginaController;
use App\Http\Controllers\Publico\SolicitacaoController;
use Illuminate\Support\Facades\Route;

// Módulo público — a entrada do site é o próprio catálogo (RF01).
Route::get('/', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/detalhe/{animal}', [CatalogoController::class, 'show'])->name('catalogo.show');
Route::post('/detalhe/{animal}/interesse', [SolicitacaoController::class, 'store'])->name('solicitacao.store');
Route::get('/acompanhar/{token}', [AcompanhamentoController::class, 'show'])->name('acompanhar.show');
Route::get('/sobre', [PaginaController::class, 'sobre'])->name('paginas.sobre');
Route::get('/contato', [PaginaController::class, 'contato'])->name('paginas.contato');

// Módulo administrativo (RF09) — rotas autenticadas.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';