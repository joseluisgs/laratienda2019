{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@section('title', 'Admin | Listado de Usuarios/as')
{{-- pasamos esta parte a todo donde ponga yield con esta eqtiqueta --}}
@section('content')

    {{-- Cuadro de busqueda (formulario) hecho con LaraavelCollective/HTML
        se llama a si mismo, por eso la ruta del controlador y método GET --}}
    {!! Form::open(['route'=>'users.index', 'method'=>'GET', 'class'=>'form-inline']) !!}
    <div class="form-group">
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre completo'])!!}
            {!! Form::submit('Buscar usuario/a', ['class'=>'btn btn-primary'])!!}
    </div>
        {{-- Mezclando código normal con códgo de LaravelCollective ¿Se ve fácil?--}}
        <a href="{{route('users.pdfAll')}}" class="btn pull-right"><span class="glyphicon glyphicon-download"></span>  Descargar</a>
        {{link_to(route('users.create'), $title = 'Añadir Usuario/a', $attributes = ['class'=>'btn btn-success pull-right'], $secure = null)}}
    {!! Form::close() !!}

    <div class="page-header clearfix"></div>

    {{-- Si hay registros --}}
    @if (count($users) > 0)
        <!-- Tabla-->
        <table class='table table-bordered table-striped'>
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>E-Mail</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Imagen</th>
                <th class="text-center">Acción</th>
            </thead>
            <tbody>
                {{--Recorrido usando $user --}}
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td class="text-center">
                            @if ($user->tipo == 'admin')
                                <span class="label label-warning">Admin</span>
                            @else
                                <span class="label label-info">Normal</span>
                            @endif

                        </td>
                        <td class="text-center">
                                @if ($user->imagen == '')
                                    <img src='{{asset('recursos/sinfoto.png')}}' class='avatar img-circle' alt='imagen' width='35' height='35'>
                                @else
                                    <img src='{{asset($user->imagen)}}' class='avatar img-circle' alt='imagen' width='35' height='35'>
                                @endif

                        </td>
                        <td class="text-center">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                                <a class='btn btn-info' href='{{route('users.show', $user->id)}}' title='Ver Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-search'></span></a>
                                <a class='btn btn-warning' href='{{route('users.edit', $user->id)}}' title='Actualizar Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>
                                <button class="btn btn-danger" type="submit" title='Borar Usuario/a' data-toggle='tooltip'
                                    onclick="return confirm('¿Seguro que desea borrar a este usuario/a?')">
                                    <span class='glyphicon glyphicon-trash'></span>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    {{--Si no hay usuarios mostramos el mensaje--}}
    @else
        <p class='lead'><em>No se ha encontrado datos de usuarios/as.</em></p>
    @endif

    {{--El paginador sólo aparece cuando superemos los usuarios puestos en paginate()
        del controlador--}}
    <div class='text-center'>
            {!! $users->render()!!}
    </div>

@endsection

