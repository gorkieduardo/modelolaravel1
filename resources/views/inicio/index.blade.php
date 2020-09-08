@extends('layouts.app')



@section('styles')
 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" /> --}}

@endsection

@section('hero')
    <div class="hero-categorias">
        <form class="container h-100" action={{ route('buscar.show') }}>
            <div class="row h-100 align-items-center">
                <div class="col-md-4 texto-buscar">
                    <p class="display-4">Encuentra una receta para tu próxima comida</p>

                    <input
                        type="search"
                        name="buscar"
                        class="form-control"
                        placeholder="Buscar Receta"
                    />
                </div>
            </div>
        </form>
    </div>
@endsection


@section( 'content')

    

   <div class="container nuevas-recetas">
        <h2 class="titulo-categoria text-uppercase mt-1 mb-4">
            Recetas Recomendadas
        </h2>
        <div class="row">
            @foreach($nuevas as $nueva)
            <div class="col-md-4">
                
            <div class="card">
            <img src='/storage/{{$nueva->imagen}}' class="card-img-top " alt="imagen receta">
            <div class="card-body">
            <h3>{{ Str::title($nueva->titulo)}}</h3>
            
            <p>{{ Str::words( strip_tags($nueva->preparacion), 4)}}</p>
            <a href="{{ route('recetas.show', ['receta'=>$nueva->id])}}" 
            
                class="btn btn-primary d-block font-weight-bold text-uppercase">
                Ver receta

            </a>
            </div>
            </div>
        </div>
            @endforeach

        </div>

   </div>

   @foreach($recetas as $key => $grupo )
   <div class="container">
       <h2 class="titulo-categoria text-uppercase mt-5 mb-4"> {{ str_replace('-', ' ',  $key) }} </h2>
       
       <div class="row">
           @foreach($grupo as $recetas)
               @foreach($recetas as $receta)
                  <div class="col-md-4 mt-4">
                      <div class="card shadow">
                      <img class="card-img-top" src="/storage/{{ $receta->imagen}}" alt="imagen receta" >
                    <div class="card-body">
                    <h3 class="card-title">{{$receta->titulo}}</h3> 
                    
                    <div class="meta-receta d-flex justify-content-between">

                        @php
                            $fecha = $receta->created_at
                        @endphp

                        <p class="text-primary fecha font-weight-bold">
                        <fecha-receta fecha="{{$fecha}}"></fecha-receta>
                        </p>
                      {{--   <p class="card-text">
                            {{ Str::words( strip_tags($nueva->preparacion), 10)}}

                        </p> --}}
                    <a href="{{ route('recetas.show', ['receta'=>$receta->id])}}" 
                        class="btn-danger">Ver receta
                    
                    </a>
                 
                    </div>
                    </div>  
                    
                    </div>

                  </div>
               @endforeach
           @endforeach
       </div>
   </div>

@endforeach

@endsection