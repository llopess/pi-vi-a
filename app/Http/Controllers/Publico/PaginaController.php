<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PaginaController extends Controller
{
    /** Páginas institucionais (RF08). */
    public function sobre(): View
    {
        return view('paginas.sobre');
    }

    public function contato(): View
    {
        return view('paginas.contato');
    }
}