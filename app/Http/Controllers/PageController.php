<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * PageController
 * Maneja todas las páginas públicas del sitio:
 * inicio, misión, visión, objetivos y servicios.
 *
 * Origen: inicio.php, mision.php, vision.php, objetivos.php, servicios.php
 */
class PageController extends Controller
{
    public function inicio()
    {
        return view('pages.inicio');
    }

    public function mision()
    {
        return view('pages.mision');
    }

    public function vision()
    {
        return view('pages.vision');
    }

    public function objetivos()
    {
        return view('pages.objetivos');
    }

    public function servicios()
    {
        return view('pages.servicios');
    }
}
