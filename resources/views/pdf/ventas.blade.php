<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Listado de Productos</title>
     <!-- CSS -->
     <link rel="stylesheet" href="{{ asset('css/imprimir.css') }}">
    <style type="text/css">
        .wrapper{
            width: 80%;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
    </style>

</head>
<body>
        <section>
                <div class="wrapper">
                    <div class="container-fluid">
                            <div class="row">
                                    <div class="col-xs-12">
                                        <h2 class="page-header">
                                            <img class="img-responsive" src='{{public_path('/recursos')}}/laravel-red2.png' alt='imagen' width='40'>
                                            <i class="fa fa-globe"></i>LaraCRUD SHOP: Listado de ventas
                                        </h2>
                                    </div>
                                </div>
                                    {{-- Si hay registros --}}
    @if (count($ventas) > 0)
    <!-- Tabla-->
    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th class="text-center">Importe</th>
            </tr>
        </thead>
        <tbody>
            {{--Recorrido usando $user --}}
            @foreach ($ventas as $venta)
                <tr>
                        <td>{{$venta->id}}</td>
                        <td>{{$venta->codigo}}</td>
                        <td>{{DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha)->format('d/m/Y')}}</td>
                        <td>{{$venta->name}}</td>
                        <td>{{$venta->total}} €</td>

                </tr>
            @endforeach
        </tbody>
    </table>

{{--Si no hay usuarios mostramos el mensaje--}}
@else
    <p class='lead'><em>No se ha encontrado datos de ventas.</em></p>
@endif
<h6>Creado: {{date('H:m:s d/m/Y')}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
</body>
</html>

