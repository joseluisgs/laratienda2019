{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@section('title', 'Admin | Editar Producto')
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

    {{-- Formulario de Datos, controlador productos, metodo store. metodo post y ficheros --}}
    {!! Form::open(['route'=>['productos.update',  $producto->id], 'method'=>'PUT', 'files'=>true, 'class'=>'form-horizontal']) !!}
    <div class="container">
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-center">
                    <img src='{{asset($producto->imagen)}}' class='avatar img-thumbnail' alt='imagen' width='135' height='auto'>
                    <h6>Sube una foto del producto</h6>
                    {{-- Imagen --}}
                    <div class="form-group">
                        {!! Form::file('imagen', ['class'=>'form-control text-center center-block well well-sm', 'accept'=>'image/jpeg']) !!}
                    </div>
                </div>
            </div>
            <!-- Columna de la derecha-->
            <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                {{-- Marca --}}
                <div class="form-group">
                    {!! Form::label('marca', 'Marca:', ['class'=>'col-lg-3 control-label']) !!}
                    <div class="col-lg-6">
                        {!! Form::text('marca', $producto->marca, ['class'=>'form-control', 'required', 'placeholder'=>'Marca del Producto'])!!}
                    </div>
                  </div>
                {{-- Modelo --}}
                <div class="form-group">
                        {!! Form::label('modelo', 'Modelo:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::text('modelo', $producto->modelo, ['class'=>'form-control', 'required', 'placeholder'=>'Modelo del Producto'])!!}
                        </div>
                </div>
                {{-- Precio --}}
                <div class="form-group">
                        {!! Form::label('precio', 'Precio (€):', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                                {!! Form::number('precio', $producto->precio, ['class'=>'form-control', 'required', 'step'=>'0.01', 'min'=>'1.00'])!!}
                        </div>
                </div>
                {{-- Tipo --}}
                <div class="form-group">
                    {!! Form::label('tipo', 'Tipo:', ['class'=>'col-lg-3 control-label']) !!}
                    <div class="col-lg-6">
                        @if ($producto->tipo == 'juego')
                            {!! Form::select('tipo', ['juego'=>'Juego', 'consola'=>'Consola'], 'juego', ['class'=>'form-control'])!!}
                        @else
                            {!! Form::select('tipo', ['juego'=>'Juego', 'consola'=>'Consola'], 'consola', ['class'=>'form-control'])!!}
                        @endif
                    </div>
                </div>
                {{-- Stock --}}
                <div class="form-group">
                        {!! Form::label('stock', 'Stock:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                                {!! Form::number('stock', $producto->stock, ['class'=>'form-control', 'required', 'step'=>'1', 'min'=>'1', 'max'=>'100'])!!}
                        </div>
                </div>
                {{-- Botones --}}
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        {!!Form::submit('Actualizar', ['class'=>'btn btn-warning'])!!}
                        {{link_to(route('productos.index'), $title = 'Volver', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                    </div>
                </div>
            </div>
          </div>
        </div>
    {!! Form::close() !!}

@endsection

