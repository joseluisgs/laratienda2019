{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@section('title', 'Admin | Listado de Ventas')
{{-- pasamos esta parte a todo donde ponga yield con esta eqtiqueta --}}
@section('content')

    {{-- Cuadro de busqueda (formulario) hecho con LaraavelCollective/HTML
        se llama a si mismo, por eso la ruta del controlador y método GET --}}
    {!! Form::open(['route'=>'ventas.index', 'method'=>'GET', 'class'=>'form-inline']) !!}
    <div class="form-group">
            {!! Form::date('fechaInicio', \Carbon\Carbon::yesterday(), ['class'=>'form-control']) !!}
            {!! Form::date('fechaFin', \Carbon\Carbon::tomorrow(), ['class'=>'form-control']) !!}
            {!! Form::submit('Buscar Venta', ['class'=>'btn btn-primary'])!!}
    </div>
        {{-- Mezclando código normal con códgo de LaravelCollective ¿Se ve fácil?--}}
        <a href="{{route('ventas.pdfAll')}}" class="btn pull-right"><span class="glyphicon glyphicon-download"></span>  Descargar</a>
    {!! Form::close() !!}

    <div class="page-header clearfix"></div>

    {{-- Si hay registros --}}
    @if (count($ventas) > 0)
        <!-- Tabla-->
        <table class='table table-bordered table-striped'>
            <thead>
                <th>ID</th>
                <th>Código</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th class="text-center">Importe</th>
                <th class="text-center">Acción</th>
            </thead>
            <tbody>
                {{--Recorrido usando $productos --}}
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{$venta->id}}</td>
                        <td>{{$venta->codigo}}</td>
                        <td>{{DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha)->format('d/m/Y')}}</td>
                        <td>{{$venta->name}}</td>
                        <td class="text-center">{{$venta->total}} €</td>
                        <td class="text-center">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['ventas.destroy', $venta->id]]) !!}
                                <a class='btn btn-info' href='{{route('ventas.show', $venta->id)}}' title='Ver Venta' data-toggle='tooltip'><span class='glyphicon glyphicon-search'></span></a>
                                <a class='btn btn-warning' href='{{route('ventas.pdf', $venta->id)}}' title='Descargar Factura' data-toggle='tooltip'><span class='glyphicon glyphicon-file'></span></a>
                                <button class="btn btn-danger" type="submit" title='Borar Venta' data-toggle='tooltip'
                                    onclick="return confirm('¿Seguro que desea borrar esta venta?')">
                                    <span class='glyphicon glyphicon-trash'></span>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    {{--Si no hay productos mostramos el mensaje--}}
    @else
        <p class='lead'><em>No se ha encontrado datos de ventas.</em></p>
    @endif

    {{--El paginador sólo aparece cuando superemos los usuarios puestos en paginate()
        del controlador--}}
    <div class='text-center'>
            {!! $ventas->render()!!}
    </div>

@endsection

