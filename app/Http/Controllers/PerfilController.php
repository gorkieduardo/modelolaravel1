<?php

namespace App\Http\Controllers;

use App\Perfil;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class PerfilController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        return view('perfiles.show', compact('perfil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {


        //validar 
        $data = request()->validate([
            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required'
        ]);
        //si el usuario sube imagen
        if ($request['imagen']) {

            $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');
            //rize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(500, 500);
            $img->save();

            //crear un arreglo de imagen
            $array_imagen = ['imagen' => $ruta_imagen];
        }
        //asignar nombre y url

        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();

        //guardar informacion

        unset($data['url']);
        unset($data['nombre']);


        auth()->user()->perfil()->update(array_merge(
            $data,
            $array_imagen ?? []
        ));
        //redireccionar
        return redirect()->action('RecetaConntroller@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
