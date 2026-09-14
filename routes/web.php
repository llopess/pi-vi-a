<?php

use App\Http\Controllers\Publico\CatalogoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/detalhe/{animal}', [CatalogoController::class, 'show'])->name('catalogo.show');