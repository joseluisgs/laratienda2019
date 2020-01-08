{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@section('title', 'Catálogo | Listado de Productos')
{{-- pasamos esta parte a todo donde ponga yield con esta eqtiqueta --}}
@section('content')

    {{-- Cuadro de busqueda (formulario) hecho con LaraavelCollective/HTML
        se llama a si mismo, por eso la ruta del controlador y método GET --}}
    <div class='text-center'>
        {!! Form::open(['route'=>'catalogo.index', 'method'=>'GET', 'class'=>'form-inline']) !!}
        <div class="form-group">
                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Marca o Modelo'])!!}
                {!! Form::submit('Buscar Producto', ['class'=>'btn btn-primary'])!!}
        </div>
        {!! Form::close() !!}
    </div>
    <hr>

    {{-- Si hay registros --}}
    @if (count($productos) > 0)
        <div class="row equal-height">
            @foreach ($productos as $producto)
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{$producto->imagen}}" class="img-fullsize img-responsive">
                            <div class="caption">
                                <h3>{{$producto->modelo}}</h3>
                                <h4>{{$producto->marca}}</h4>
                                <h5>{{$producto->precio}} €</h5>
                                @if ($producto->tipo == 'juego')
                                        <span class="label label-warning">Juego</span>
                                    @else
                                        <span class="label label-info">Cosola</span>
                                    @endif
                                <p class="text-center">
                                    <br>
                                    {{-- Botón de Comprar --}}
                                    @if ($producto->stock>0)
                                        {{link_to(route('carrito.insertar', $producto->id), $title = 'Comprar', $attributes = ['class'=>'btn btn-success'], $secure = null)}}
                                    @else
                                        {{link_to('#', $title = 'Sin Stock', $attributes = ['class'=>'btn btn-danger'], $secure = null)}}
                                    @endif
                                    {{-- Botón de ver más --}}
                                    {{link_to(route('catalogo.show', $producto->id), $title = 'Mas..', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                                </p>
                            </div>
                    </div>
                </div> <!-- /.col-xs-6.col-md-3 -->
            @endforeach
        </div>

    {{--Si no hay productos mostramos el mensaje--}}
    @else
        <p class='lead'><em>No se ha encontrado datos de productos.</em></p>
    @endif
    {{--El paginador sólo aparece cuando superemos los usuarios puestos en paginate()
        del controlador--}}
    <div class='text-center'>
            {!! $productos->render()!!}
    </div>
@endsection

