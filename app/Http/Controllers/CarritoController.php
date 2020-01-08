<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Cart;
use Auth;
use App\Producto;
use App\Venta;
use App\Pago;
use App\Envio;
use App\LineaVenta;
use Illuminate\Support\Facades\Mail;


class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carrito.index');
    }


    /**
     * Inserta un elemento en el carrito
     */
    public function insertar($id)
    {
        // Lo localizamos
        $producto = Producto::find($id);
        // lo insertamos asociandole el modelo del item
        Cart::add($producto,1);
        //Cart::add($producto->id, $producto->modelo, 1, $producto->precio)->associate($producto);
        flash('Producto '. $producto->modelo.'  añadido al carrito.')->success()->important();
        return redirect()->route('carrito.index'); // Volvemos a la vista
    }

    /**
     * Borrar un elemento del carrito
     */
    public function eliminar($id)
    {
        // sacamos su nombre
        $nombre = Cart::get($id)->name;
        Cart::remove($id);
        flash('Producto '.$nombre.'  eliminado del carrito.')->error()->important();
        return redirect()->route('carrito.index'); // Volvemos a la vista
    }

    public function actualizar (Request $request)
    {
        //Lo modificamos
        Cart::update($request->id, $request->cantidad);
        flash('Producto '.$request->nombre.'  modificado en el carrito.')->warning()->important();
        return redirect()->route('carrito.index'); // Volvemos a la vista
    }

    public function vaciar ()
    {
        //Lo destruimos
        Cart::destroy();
        flash('Carrito eliminado')->warning()->important();
        return redirect()->route('catalogo.index'); // Volvemos a la vista
    }

    public function venta()
    {
        return view('carrito.venta');
    }

    public function salvar(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'tTitular'=>'min:4|max:120|required',
            'nombre'=> 'min:4|max:120|required',
            'direccion'=> 'min:4|max:120|required',
            'ciudad'=> 'min:4|max:120|required',
            'provincia'=> 'min:4|max:120|required',
            'codigoPostal'=> 'min:5|max:5|required',
            'telefono'=> 'min:9|max:15|required',
            'email'=> 'min:4|max:120|required'
        ]);

        try{

            // Creamos la venta con los campos
            $venta = new Venta();
            $venta->codigo = Auth::user()->id.'-'.time().'-'.strftime("%Y%m%d");
            $venta->fecha =  date('Y-m-d H:i:s');
            // Lo hago así porque el carrito ya tiene el iva en el precio
            // Es por ello que se lo tengo que quitar porque mis precios ya lo llevan
            $venta->total = round(Cart::subtotal(),2);
            $venta->subtotal = round((Cart::subtotal()/1.21),2);
            $venta->iva = round((Cart::tax()/1.21),2);
            $venta->user_id = Auth::user()->id;
            // Salvamos y ya tenemos su ID en $venta->id
            $venta->save();

            // Creamos el pago
            $pago = new Pago();
            $pago->titular = $request->tTitular;
            $pago->tipo = $request->tTipo;
            $pago->numero = substr($request->tNumero,-4);
            $pago->cvv = $request->tCVV;
            $pago->mes = $request->tMes;
            $pago->año = $request->tAño;
            $pago->venta_id = $venta->id;
            // Salvamos el envío y ya tenemos su id $pago->id
            $pago->save();

            // Creamos el envío
            $envio = new Envio();
            $envio->nombre= $request->nombre;
            $envio->direccion = $request->direccion;
            $envio->ciudad = $request->ciudad;
            $envio->provincia = $request->provincia;
            $envio->codigoPostal = $request->codigoPostal;
            $envio->telefono = $request->telefono;
            $envio->email = $request->email;
            $envio->venta_id = $venta->id;
            // Salvamos el envío y ya tenemos su id $envio->id
            $envio->save();

            // Recorremos el carrito, creamos cada línea de venta y la insertamos
            $lineas=[];
            foreach (Cart::content() as $item){
                // Creamos la línea de venta
                $linea = new LineaVenta();
                $linea->venta_id = $venta->id;
                $linea->producto = $item->name;
                $linea->precio = $item->price;
                $linea->cantidad = $item->qty;
                $linea->total = $item->subtotal;
                $linea->producto_id = $item->model->id;
                // Salvamos la línea y ya tenemos su id $linea->id
                $linea->save();
                $lineas[]=$linea;
                // Actualizamos el stock de productos
                $producto = $item->model;
                $producto->stock-= $linea->cantidad;
                $producto->save();
            }

            //Salvamos y destruimos el carrito (por tenerlo también, es opcional lo de salvar)
            Cart::store($venta->codigo); // opcional
            Cart::destroy();


            // Podríamos llamar a la vista directamente sin pasar por la ruta
            // Es lo más normal, pero así me sirve para otras cosas lo que voy a hacer
            //return view('carrito.factura',
            //    ['venta' => $venta,
            //    'lineas' => $lineas,
            //    'pago' => $pago,
            //    'envio' => $envio
            //    ]);

            // Creamos el PDF
            $pdf = PDF::loadView('pdf.factura',
             ['venta'=>$venta,
             'pago'=>$pago,
             'envio'=>$envio,
             'lineas'=>$lineas
             ]);
         // La salvamos en el disco duro
         $pdf->save(storage_path('app/facturas/factura.pdf'));

         // Mandamos el email
         // Data contiene los parametros que le pasamos a la vista
         $data = ['venta'=>$venta,
                'envio'=>$envio,
                'pago'=>$pago,
                'lineas'=>$lineas
                ];
         // Le pasamos los objetos a usar como parámetros del mail en use
         // Si quereís que el mail vaya al susuario que lo ha comprado
         // No paseís user y pasar el usuario actual que es Auth::user()
         Mail::send('mails.compra', $data, function ($message) use ($venta, $envio) {
            $message->from('laracrud@tienda.com', 'LaraCRUD-SHOP');
            $message->to($envio->email, 'José Luis');
            $message->subject('Confirmación de compra: '. $venta->codigo);
            $message->attach(storage_path('app/facturas/').'factura.pdf', [ // ficheros adjuntos
                'as' => 'factura.pdf',
                'mime' => 'application/pdf',
            ]);
        });

        flash('Venta realizada con éxito. Imprima o descargue su factura, luego finalice')->success()->important();
        return redirect()->route('carrito.factura', $venta->codigo);
        }catch(\Exception $e){
            // Nos cargamos la venta, como tiene delete on cascade cae todo
            $venta->delete();
            flash('Error al procesar la venta '.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }


    public function factura($id){
        // Buscamos la venta
        $venta = Venta::where("codigo",$id)->first();
        if(($venta->user_id==Auth::user()->id)|| Auth::user()->tipo=='admin'){
            // Buscamos el pago
            $pago = Pago::where("venta_id",$venta->id)->first();
            // Buscamos el envio
            $envio = Envio::where("venta_id",$venta->id)->first();
            // Buscamos las líneas
            $lineas = LineaVenta::where("venta_id",$venta->id)->get();
            // Mostramos las vista, solo si somos el usuario o administrador
            return view('carrito.factura',
                ['venta' => $venta,
                'pago' => $pago,
                'envio' => $envio,
                'lineas' => $lineas
                ]);
        }else{
            return abort(404);
        }
    }

    public function descargar($id){
        // Buscamos la venta
        $venta = Venta::where("codigo",$id)->first();
        if(($venta->user_id==Auth::user()->id)|| Auth::user()->tipo=='admin'){
            // Buscamos el pago
            $pago = Pago::where("venta_id",$venta->id)->first();
            // Buscamos el envio
            $envio = Envio::where("venta_id",$venta->id)->first();
            // Buscamos las líneas
            $lineas = LineaVenta::where("venta_id",$venta->id)->get();
            // Mostramos las vista, solo si somos el usuario o administrador
            $pdf = PDF::loadView('pdf.factura',
                ['venta'=>$venta,
                'pago'=>$pago,
                'envio'=>$envio,
                'lineas'=>$lineas
                ]);
            //Creamos el nombre del fichero e iniciamos su descarga
            $fichero = 'factura-'.$venta->codigo.'.pdf';
            return $pdf->download($fichero);
        }else{
            return abort(404);
        }
    }
}
