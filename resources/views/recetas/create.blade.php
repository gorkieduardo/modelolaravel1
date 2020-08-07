
@extends('layouts.app')

@section('botones')
<a href="{{ route('recetas.index')}}" class='btn btn-primary mr-2 text-white'> Volver</a>
@endsection

@section( 'content')
<h2 class='text-center mb-5'>Crear nueva receta</h2>

<div class="row-justify-content-center mt-5">

    <div class="col-md-8">

    <form method="POST" action="{{ route('recetas.store') }}" novalidate>
        @csrf
            <div class="form-group">
                <label for="titulo">Título Receta</label>
                <input type="text" 
                name="titulo" 
                class="form-control @error('titulo') is-invalid @enderror"
                id="titulo"
                placeholder="Titulo receta"
                value="{{old('titulo')}}"
                />
@error('titulo')
   <span class="invalid-feedback d-block" role= "alert">
   <strong>{{$message}}</strong>
   </span>
@enderror
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Agregar receta">
            </div>

        </form>
    </div>
</div>
@endsection