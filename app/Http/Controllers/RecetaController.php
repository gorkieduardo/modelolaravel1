<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class RecetaController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Auth::user()->recetas->dd();, aunque también se puede auth()->user()->recetas->dd()
        $recetas = auth()->user()->recetas;
        return view('recetas.index')->with('recetas', $recetas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        //DB::table('categoria_receta')->get()->pluck('nombre', 'id')->dd();
        //obtener la categoria sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

        //obtener cateogría con modelo

        $categorias = CategoriaReceta::all(['id', 'nombre']);
        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        //  dd($request['imagen']->store('upload-recetas', 'public'));
        //Validación
        $data = request()->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'imagen' => 'required|image',
            'ingredientes' => 'required'
        ]);
        //ruta
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');


        //rize de la imagen

        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1200, 550);
        $img->save();

        //almacenar en base de datos(con modelo);

        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'preparacion' => $data['preparacion'],
            'ingredientes' => $data['ingredientes'],
            'imagen' => $ruta_imagen,

            'categoria_id' => $data['categoria'],
        ]);

        //Redireccionar
        return redirect()->action('RecetaController@index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)


    {

        return view('recetas.show', compact('receta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $categorias = CategoriaReceta::all(['id', 'nombre']);
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)

    //revisar el plice


    {

        $this->authorize('update', $receta);

        $data = request()->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',

            'ingredientes' => 'required'
        ]);
        //asignar valors

        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        $receta->save();

        //cambio de imagen
        if (request('imagen')) {
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
            //rize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1200, 550);
            $img->save();

            //asignamos al objetov
            $receta->imagen = $ruta_imagen;
        }

        //redireccionar
        $receta->save();

        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //ejecutar el plicy
        // return "eliminando...";
        $this->authorize('delete', $receta);
        $receta->delete();
        return redirect()->action('RecetaController@index');
    }
}
