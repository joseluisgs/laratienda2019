{{-- Heredamos de nuestra plantilla --}}
@extends('template.main')
{{-- Ponemos el título --}}
@section('title', 'Compra de '. Auth::user()->name)
{{-- pasamos esta parte a todo donde ponga yield con esta eqtiqueta --}}
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
{{-- Si está vacío, volvemos al carrito, podria utilizar un header de php pero conocer formas siempre es bueno --}}
@if (Cart::count()==0)

    <script type="text/javascript">
        window.location = "{{route('carrito.index')}}";
    </script>
@else
{{-- Iniciamos la interfaz --}}
<div class="row cart-body">
    {{-- Formulario --}}
    {!! Form::open(['route'=>'carrito.salvar', 'method'=>'POST', 'class'=>'form-horizontal']) !!}
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
        {{-- Panel de resumen de pedido --}}
        <div class="panel panel-default">
            <div class="panel-heading">
                Pedido
                <div class="pull-right">
                    <small>{{link_to(route('carrito.index'), $title = 'Editar', $secure = null)}}</small>
                </div>
            </div>
            {{-- Resumen de la cesta de compra --}}
            <div class="panel-body">
                {{--Para cada producto de la cesta--}}
                @foreach (Cart::content() as $item)
                    <div class="form-group">
                            <div class="col-sm-3 col-xs-3">
                                {{--imagen--}}
                                <img class="img-responsive" src='{{asset($item->model->imagen)}}' alt='imagen' width='70'>
                            </div>

                            <div class="col-sm-6 col-xs-6">
                                <div class="col-xs-12">{{$item->name}}</div>
                                <div class="col-xs-12"><small>Precio: <span>{{$item->price}} €</span></small></div>
                                <div class="col-xs-12"><small>Cantidad: <span>{{$item->qty}}</span></small></div>
                            </div>
                            <div class="col-sm-3 col-xs-3 text-right">
                                <h6>{{$item->subtotal}} €</h6>
                            </div>
                        </div>
                    <div class="form-group"><hr></div>
                @endforeach
                {{-- Subtotales y totales --}}
                <div class="form-group">
                    <div class="col-xs-12">
                            Subtotal:
                        <div class="pull-right"><span>{{round((Cart::subtotal()/1.21),2)}} €</span></div>
                    </div>
                    <div class="col-xs-12">
                        <small>I.V.A.: </small>
                        <div class="pull-right"><span>{{round((Cart::tax()/1.21),2)}} €</span></div>
                    </div>
                    <div class="col-xs-12">
                            <strong>TOTAL: </strong>
                            <div class="pull-right"><span><strong>{{Cart::subtotal()}} €</strong></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
        {{-- Panel de Envío --}}
        <div class="panel panel-default">
            <div class="panel-heading">Envío</div>
            <div class="panel-body">
                {{-- Nombre --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('nombre', 'Nombre:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('nombre', Auth::user()->name, ['class'=> 'form-control', 'required', 'placeholder'=>'Nombre Completo'])!!}
                    </div>
                </div>
                {{-- Direccion --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('direccion', 'Dirección:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('direccion', null, ['class'=> 'form-control', 'required', 'placeholder'=>'Dirección de envío'])!!}
                    </div>
                </div>
                {{-- Direccion --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('ciudad', 'Ciudad:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('ciudad', null, ['class'=> 'form-control', 'required', 'placeholder'=>'Ciudad'])!!}
                    </div>
                </div>
                {{-- Provincia --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('provincia', 'Provincia:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('provincia', null, ['class'=> 'form-control', 'required', 'placeholder'=>'Provincia'])!!}
                    </div>
                </div>
                {{-- CP --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('codigoPostal', 'Código postal:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('codigoPostal', null, ['class'=> 'form-control', 'required', 'placeholder'=>'Código postal'])!!}
                    </div>
                </div>
                {{-- Telefono --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('telefono', 'Teléfono:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('telefono', null, ['class'=> 'form-control', 'required', 'placeholder'=>'Teléfono'])!!}
                    </div>
                </div>
                {{-- Email --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('email', 'Correo electrónico:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::email('email', Auth::user()->email, ['class'=> 'form-control', 'required', 'placeholder'=>'email'])!!}
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin Panel de Envío --}}
         {{-- Panel de pago --}}
        <div class="panel panel-info">
            <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Pago electrónico</div>
            <div class="panel-body">
                    <div class="form-group">
                            <div class="col-md-12 text-center">
                                <img src="{{asset('/recursos/tarjetas.png')}}">
                        </div>
                    </div>
                {{-- Tipo de tarjeta --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tTipo', 'Tipo de Tarjera:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::select('tTipo',
                            ['Visa'=>'Visa',
                            'MasterCard'=>'MasterCard',
                            'AmericanExpress'=>'AmericanExpress',
                            'Discover'=>'Discover',
                            'PayPal'=>'Paypal'],
                            "Visa", ['class'=>'form-control', 'required'])!!}
                    </div>
                </div>
                {{-- Nombre --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tTitular', 'Titular:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('tTitular', Auth::user()->name, ['class'=> 'form-control', 'required', 'placeholder'=>'Titular de tarjeta'])!!}
                    </div>
                </div>
                {{-- Número --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tNumero', 'Numero:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('tNumero', null, ['class'=> 'form-control', 'required', 'pattern'=>'[0-9]{13,16}', 'placeholder'=>'Num. de tarjeta'])!!}
                    </div>
                </div>
                {{-- CVV --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tCVV', 'CVV:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('tCVV', null, ['class'=> 'form-control', 'required', 'pattern'=>'[0-9]{3}', 'placeholder'=>'CVV'])!!}
                    </div>
                </div>
                {{-- Tipo de tarjeta --}}
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tMes', 'Caducidad:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        {!! Form::select('tMes',
                            ['01'=>'Enero (01)',
                            '02'=>'Febrero (02)',
                            '03'=>'Marzo (03)',
                            '04'=>'Abril (04)',
                            '05'=>'Mayo (05)',
                            '06'=>'Junio (06)',
                            '07'=>'Julio (07)',
                            '08'=>'Agosto (08)',
                            '09'=>'Septiembre (09)',
                            '10'=>'Octubre (10)',
                            '11'=>'Noviembre (11)',
                            '12'=>'Diciembre (12)',
                            ], null, ['class'=>'form-control', 'required'])!!}
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            {!! Form::select('tAño',
                                ['19'=>'2019',
                                '20'=>'2020',
                                '21'=>'2021',
                                '22'=>'2022',
                                '23'=>'2023',
                                '24'=>'2024',
                                '25'=>'2025',
                                '26'=>'2026',
                                '27'=>'2027',
                                '28'=>'2028',
                                '29'=>'2029',
                                ], null, ['class'=>'form-control', 'required'])!!}
                     </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-center text-center">
                        {{-- Pagar --}}
                        {!!Form::submit('Pagar y finalizar compra', ['class'=>'btn btn-success'])!!}
                        {{-- Seguir comprando --}}
                        {{link_to(route('catalogo.index'), $title = 'Continuar comprando', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin de pago --}}
    </div>
    {{-- Fin de formulario --}}
    {!! Form::close() !!}
</div>
<div class="row cart-footer">
        @endif

@endsection

