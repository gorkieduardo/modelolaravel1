<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {

        $nuevas = Receta::latest()->limit(6)->get();

        // return $nuevas;

        return view('inicio.index', compact('nuevas'));
    }
    //
}
