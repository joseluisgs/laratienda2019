{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@auth
    @section('title', 'Carrito de compra de '. Auth::user()->name)
@else
@section('title', 'Carrito de compra')
@endauth

{{-- pasamos esta parte a todo donde ponga yield con esta eqtiqueta --}}
@section('content')

{{-- Si el carito no está vacío --}}
@if (sizeof(Cart::content()) > 0)
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">

                {{-- Incio de la tabla --}}
                <table class="table table-hover">
                    {{-- Cabecera de la tabla --}}
                    <thead>
                        <tr>
                            <th class="table-image"></th>
                            <th class="text-left">Producto</th>
                            <th class="text-right">Precio</th>
                            <th>Cantidad</th>
                            <th class="text-right">Total</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    {{-- Fin Cabecera de la tabla --}}
                    {{-- Cuerpo de la tabla --}}
                    <tbody>
                        @foreach (Cart::content() as $item)
                            {{-- Inicio de fila --}}
                            <tr>
                                {{-- Imagen --}}
                                <td class='col-sm-1 col-md-1'><img src='{{asset($item->model->imagen)}}' class='avatar img-thumbnail' alt='imagen' width='60'>
                                {{-- Nombre --}}
                                <td class='col-sm-8 col-md-6 text-left'>
                                    <h4>{{$item->name}}</h4>
                                    <h5>{{$item->model->marca}}</h5>
                                </td>
                                {{-- precio --}}
                                <td class="col-sm-1 col-md-1 text-right"><h5>{{$item->price}} €</h5></td>
                                {{-- Cantidad --}}
                                <td class="col-sm-1 col-md-1 text-center">
                                    {!! Form::open(['route'=>'carrito.actualizar', 'method'=>'POST']) !!}
                                        {!! Form::hidden('id', $item->rowId, ['class'=>'form-control'])!!}
                                        {!! Form::hidden('nombre', $item->name, ['class'=>'form-control'])!!}
                                        {!! Form::number('cantidad', $item->qty, ['class'=>'form-control', 'step'=>'1', 'min'=>'1', 'max'=>$item->model->stock, 'onchange="submit()"'])!!}
                                    {!! Form::close() !!}
                                </td>
                                {{-- Total --}}
                                <td class="col-sm-1 col-md-1 text-right"><h5><strong>{{round(($item->subtotal), 2)}} €</strong></h5></td>
                                {{-- Eliminar --}}
                                <td class="col-sm-1 col-md-1 text-right">
                                    {!! Form::open(['route'=>['carrito.eliminar', $item->rowId], 'method'=>'DELETE']) !!}
                                    {{-- Utilizo un botón normal por el hecho de ponerle el icono y no uso el método de LaravelCollective--}}
                                        <button class="btn btn-danger" type="submit" title='Borar Producto' data-toggle='tooltip'
                                            onclick="return confirm('¿Seguro que desea borrar a este producto?')">
                                            <span class='glyphicon glyphicon-trash'></span>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            {{-- Fin de fila de fila --}}
                        @endforeach
                    </tbody>
                    {{-- Fin Cuerpo de la tabla --}}
                    {{-- Pie de Tabla --}}
                    <tfoot>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td class="col-sm-1 col-md-1 text-right">
                                <h5><strong><span id='subTotal'>SubTotal: </span></strong></h5>
                                <h5><strong><span id='iva'>I.V.A.: </span></strong></h5>
                                <h4><strong><span id='iva'>TOTAL: </span></strong></h4>
                            <td class="col-sm-8 col-md-6 text-right">
                                {{-- Esto lo hago así porque el precio incluye el IVA --}}
                                {{-- si no usaria la funcion subtotal, tax y total --}}
                                <h5><strong><span id='subTotal'>{{round((Cart::subtotal()/1.21),2)}} €</span></strong></h5>
                                <h5><strong><span id='iva'>{{round((Cart::tax()/1.21),2)}} €</span></strong></h5>
                                <h4><strong><span id='precioTotal'>{{Cart::subtotal()}} €</span></strong></h4>
                            </td>
                            <td>   </td>
                        </tr>

                        <tr>
                            <td>
                                {{-- Seguir comprando --}}
                                {{link_to(route('catalogo.index'), $title = 'Continuar comprando', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                            </td>
                            <td>   </td>

                            <td>
                                {{-- Vaciar Carrito --}}
                                {{link_to(route('carrito.vaciar'), $title = 'Vaciar carrito', $attributes = ['class'=>'btn btn-danger', 'onclick'=>"return confirm('¿Seguro que desea vaciar el carrito?')"], $secure = null)}}
                            </td>
                            <td>   </td><td>   </td>
                            <td>
                                {{-- Pagar Carrito --}}
                                {{link_to(route('carrito.venta'), $title = 'Pagar compra', $attributes = ['class'=>'btn btn-success'], $secure = null)}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@else
{{-- Si el carrito está vacío --}}
<p class='lead'><em>No hay productos en su carrito.</em></p>
{{-- Seguir comprando --}}
{{link_to(route('catalogo.index'), $title = 'Continuar comprando', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
@endif
@endsection

