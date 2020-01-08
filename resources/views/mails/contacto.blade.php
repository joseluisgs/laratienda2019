{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@section('title', 'Formulario de contacto')
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
    {!! Form::open(['route'=>'contacto.enviar', 'method'=>'POST', 'class'=>'form-horizontal']) !!}
    <div class="container">
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-center">
                    <img src='{{asset('recursos/email.png')}}' class='avatar' alt='imagen' width='200' height='auto'>
                </div>
            </div>
            <!-- Columna de la derecha-->
            <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                {{-- Nombre --}}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre:', ['class'=>'col-lg-3 control-label']) !!}
                    <div class="col-lg-6">
                        {!! Form::text('nombre', null, ['class'=>'form-control', 'required', 'placeholder'=>'Nombre Completo'])!!}
                    </div>
                  </div>
                {{-- Email --}}
                <div class="form-group">
                        {!! Form::label('correo', 'Correo Electrónico:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::email('correo', null, ['class'=>'form-control', 'required', 'placeholder'=>'direccion@dominio.com'])!!}
                        </div>
                </div>
                {{-- Password --}}
                <div class="form-group">
                        {!! Form::label('comentario', 'Comentario:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::textarea('comentario', null, ['class'=>'form-control', 'required'])!!}
                        </div>
                </div>
                {{-- Botones --}}
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        {!!Form::submit('Enviar', ['class'=>'btn btn-primary'])!!}
                        {{link_to(url('/'), $title = 'Volver', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                    </div>
                </div>
            </div>
          </div>
        </div>
    {!! Form::close() !!}

@endsection

