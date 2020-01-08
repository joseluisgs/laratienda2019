{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@section('title', 'Catalogo | Ficha: '. $producto->modelo)
{{-- Contenido --}}
@section('content')

    {{-- Codigos de validación de los errores, ver request validate del controlador --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br/>
    @endif

    {{-- Formulario de Datos, controlador user, metodo store. metodo post y ficheros --}}
    {!! Form::open(['route'=>['carrito.insertar', $producto->id], 'method'=>'GET', 'class'=>'form-horizontal']) !!}
    <div class="container">
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-center">
                    {{-- Imagen --}}
                    <img src='{{asset($producto->imagen)}}' class='avatar img-thumbnail' alt='imagen' width='165' height='165'>
                </div>
            </div>
            <!-- Columna de la derecha-->
            <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                {{-- Marca --}}
                <div class="form-group">
                    {!! Form::label('marca', 'Marca:', ['class'=>'col-lg-3 control-label']) !!}
                    <div class="col-lg-6">
                        {!!Form::label('marca', $producto->marca, ['class'=>'form-control'])!!}
                    </div>
                  </div>
                {{-- Modelo--}}
                <div class="form-group">
                        {!! Form::label('modelo', 'Modelo:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::label('modelo', $producto->modelo, ['class'=>'form-control'])!!}
                        </div>
                </div>
                {{-- Precio --}}
                <div class="form-group">
                        {!! Form::label('Precio', 'Precio (€):', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::label('precio', $producto->precio, ['class'=>'form-control'])!!}
                        </div>
                </div>
                {{-- Tipo --}}
                <div class="form-group">
                        {!! Form::label('tipo', 'Tipo:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            @if ($producto->tipo == 'juego')
                                {!! Form::label('tipo', "Juego", ['class' => 'label label-warning'])!!}
                            @else
                                {!! Form::label('tipo', "Consola", ['class' => 'label label-info'])!!}
                            @endif
                        </div>
                </div>
                {{-- Botones --}}
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        {{-- Botón Comprar --}}
                        @if ($producto->stock>0)
                            {!!Form::submit('Comprar', ['class'=>'btn btn-success'])!!}
                        @else
                            {{link_to(route('catalogo.index'), $title = 'Sin Stock', $attributes = ['class'=>'btn btn-danger'], $secure = null)}}
                        @endif
                        {{-- Botón Volver --}}
                        {{link_to(route('catalogo.index'), $title = 'Volver', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                    </div>
                </div>
            </div>
          </div>
        </div>
    {!! Form::close() !!}

@endsection

