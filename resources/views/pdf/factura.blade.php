<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icono de la página como asset -->
    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}">

    {{-- Al llamar a la página insertaremos el titulo con yield --}}
    <title>Factura: {{$venta->codigo}}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/imprimir.css') }}">
     <!-- Estilos de la factura -->
    <style>
            .invoice-title h2, .invoice-title h3 {
            display: inline-block;
            }
            .table > tbody > tr > .no-line {
                border-top: none;
            }
            .table > thead > tr > .no-line {
                border-bottom: none;
            }
            .table > tbody > tr > .thick-line {
                border-top: 2px solid;
            }
     </style>
</head>

<body>

<section class="content content_content" style="width: 80%; margin: auto;">
    <section class="invoice">
        {{-- Titulo --}}
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <img class="img-responsive" src='{{public_path('/recursos')}}/laravel-red2.png' alt='imagen' width='40'>
                    <i class="fa fa-globe"></i>LaraCRUD SHOP
                    <h5 class="pull-right">Factura nº: {{$venta->codigo}}</h5>
                </h2>
            </div>
        </div>
        {{-- Columnas de información de pedido --}}
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Facturado a:</strong><br>
                        {{$pago->titular}}<br>
                        Tipo: {{$pago->tipo}}<br>
                        Nº: finalizado en **** {{$pago->numero}}<br>
                        Pagado: {{DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha)->format('d/m/Y')}}<br>
                        <strong>Fecha de pedido:</strong><br>
                                {{DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha)->format('d/m/Y')}}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			    <strong>Enviado a:</strong><br>
                        {{$envio->nombre}}<br>
                        C/ {{$envio->direccion}}<br>
                        {{$envio->ciudad}}<br>
                        {{$envio->provincia}}, C.P.: {{$envio->codigoPostal}}<br>
                        Telf: {{$envio->telefono}}<br>
                        Email: {{$envio->email}}
    				</address>
    			</div>
            </div>
    </div>
    {{-- Columna de datos --}}
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Resumen de pedido</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Producto</strong></td>
        							<td class="text-center"><strong>Precio</strong></td>
        							<td class="text-center"><strong>Cantidad</strong></td>
        							<td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                {{-- Para cada línea de pedido --}}
                                @foreach ($lineas as $linea)
                                    <tr>
                                        <td>{{$linea->producto}}</td>
                                        <td class="text-center">{{$linea->precio}} €</td>
                                        <td class="text-center">{{$linea->cantidad}}</td>
                                        <td class="text-right">{{$linea->total}} €</td>
                                    </tr>
                                @endforeach

                                {{-- Totales --}}
    							<tr>
    								<td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    {{-- Totales y subtotales --}}
    								<td class="thick-line text-right"><strong>Subtotal:</strong></td>
    								<td class="thick-line text-right">{{$venta->subtotal}} €</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>I.V.A.:</strong></td>
    								<td class="no-line text-right">{{$venta->iva}} €</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>TOTAL:</strong></td>
    								<td class="no-line text-right">{{$venta->total}} €</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    </section>
</section>
</body>
</html>
