<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
// Importamos el modelo
use Auth;
use App\User;
use \Carbon\Carbon;
use App\Venta;
use App\Producto;
use App\Pago;
use App\Envio;
use App\LineaVenta;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Buscamos la venta
        // Me quedo con las ventas de mi id
        $user_id = Auth::user()->id;
        // Obtengo las fechas con carbon si no me llegan del buscador
        $fechaInicio = Carbon::parse('2018-01-11');//Carbon::yesterday();
        $fechaFin = Carbon::tomorrow();
        if($request->fechaInicio && $request->fechaFin){
            $fechaInicio = $request->fechaInicio;
            $fechaFin = $request->fechaFin;
        }
        // Saco las ventas
        $compras = Venta::where('user_id', $user_id)
        ->whereBetween('fecha', [$fechaInicio, $fechaFin])
        ->join('users', 'users.id', '=', 'ventas.user_id')
        ->select('ventas.id', 'ventas.codigo', 'ventas.fecha','users.name', 'ventas.total')
        ->orderBy('ventas.fecha', 'desc')
        ->paginate(4);
        return view('/home')->with('compras', $compras);
    }
    
    public function update(Request $request, $id)
    {
        //Validamos los datos
        $request->validate([
            'name'=>'min:4|max:120|required',
            'email'=> 'min:4|max:250|required',
        ]);
        try{
             // Lo encontramos
            $user = User::find($id);
            // Lo actualizamos
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            // Si ha cambiado la imagen y existe la antigua
            if($request->imagen){
                // la borramos si existe
                if(Storage::exists($user->imagen)){
                    Storage::delete($user->imagen);
                }
                // Copiamos la imagen y obtenemos su path
                $user->imagen = $request->file('imagen')->store('storage');
            }
            // Salvamos (actualizamos) en la BD
            $user->save();
            flash('Usuario/a '. $user->name.'  modificado/a con éxito.')->success()->important();
            return redirect()->route('home');
        }catch(\Exception $e){
            flash('Error al modificar el Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscamos mis compras
        $venta = Venta::find($id);
        if(($venta->user_id==Auth::user()->id)){
            // Buscamos el pago
            $pago = Pago::where("venta_id",$venta->id)->first();
            // Buscamos el envio
            $envio = Envio::where("venta_id",$venta->id)->first();
            // Buscamos las líneas, pero ojo, queremos las imagenes para enlazarlas
            // No puedo hacerlo así, si no con un join (podría enlazándolo en la interfaz, pero me gusta menos)
            // $lineas = LineaVenta::where("venta_id",$venta->id)->get();
            $lineas = LineaVenta::where("venta_id",$venta->id)
            ->join('productos', 'productos.id', '=', 'linea_ventas.producto_id')
            ->select('linea_ventas.producto', 'linea_ventas.precio', 'linea_ventas.cantidad',
            'linea_ventas.total', 'productos.imagen')
            ->get();
            // Mostramos las vista, solo si somos el usuario o administrador
            return view('home.compra',
            ['venta' => $venta,
            'pago' => $pago,
            'envio' => $envio,
            'lineas' => $lineas
            ]);
        }else{
            return abort(404);
        }
    }

    public function pdf($id)
    {
        // Buscamos la venta
        $venta = Venta::find($id);
        if(($venta->user_id==Auth::user()->id)){
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
