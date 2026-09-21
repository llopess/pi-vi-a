<?php

use App\Http\Controllers\Publico\CatalogoController;
use App\Http\Controllers\Publico\SolicitacaoController;
use App\Http\Controllers\Publico\AcompanhamentoController;
use App\Http\Controllers\Publico\PaginaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/detalhe/{animal}', [CatalogoController::class, 'show'])->name('catalogo.show');
Route::post('/detalhe/{animal}/interesse', [SolicitacaoController::class, 'store'])->name('solicitacao.store');
Route::get('/acompanhar/{token}', [AcompanhamentoController::class, 'show'])->name('acompanhar.show');
Route::get('/sobre', [PaginaController::class, 'sobre'])->name('paginas.sobre');
Route::get('/contato', [PaginaController::class, 'contato'])->name('paginas.contato');