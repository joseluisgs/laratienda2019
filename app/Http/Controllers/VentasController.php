<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Cart;
use \Carbon\Carbon;
use App\Venta;
use App\Producto;
use App\Pago;
use App\Envio;
use App\LineaVenta;


class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Obtengo las fechas con carbon si no me llegan del buscador
        $fechaInicio = Carbon::parse('2018-01-11');//Carbon::yesterday();
        $fechaFin = Carbon::tomorrow();
        if($request->fechaInicio && $request->fechaFin){
            $fechaInicio = $request->fechaInicio;
            $fechaFin = $request->fechaFin;
        }
        // Saco las ventas
        $ventas = Venta::whereBetween('fecha', [$fechaInicio, $fechaFin])
        ->join('users', 'users.id', '=', 'ventas.user_id')
        ->select('ventas.id', 'ventas.codigo', 'ventas.fecha','users.name', 'ventas.total')
        ->orderBy('ventas.fecha', 'desc')
        ->paginate(4);
        return view('admin.ventas.index')->with('ventas', $ventas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscamos la venta
        $venta = Venta::find($id);
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
        return view('admin.ventas.venta',
        ['venta' => $venta,
        'pago' => $pago,
        'envio' => $envio,
        'lineas' => $lineas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            // Localizamos y creamos el objeto
            $venta= Venta::find($id);
            //borramos
            $venta->delete();
            flash('Venta '. $venta->codigo.'  eliminada con éxito.')->error()->important();
            return redirect()->route('ventas.index');
        }catch(\Exception $e){
            flash('Error al eliminar venta '. $venta->codigo.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
    /**
     * Crea una vista en PDF con los datos de los usuarios
     */
    public function pdfAll()
    {
        $ventas = Venta::join('users', 'users.id', '=', 'ventas.user_id')
        ->select('ventas.id', 'ventas.codigo', 'ventas.fecha','users.name', 'ventas.total')
        ->orderBy('ventas.fecha', 'desc')
        ->get();
        // creamos la vista
        $pdf = PDF::loadView('pdf.ventas', compact('ventas'));
        // Creamos el nombre del fichero e iniciamos su descarga
        $fichero = 'ventas-'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
    /**
     * Crea una vista en PDF con los datos de un usuario
     */
    public function pdf($id)
    {
        // Buscamos la venta
        $venta = Venta::find($id);
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
        // La salvamos en el disco duro
        //$pdf->save(storage_path('/app/facturas/'.$venta->codigo.'.pdf'));
        return $pdf->download($fichero);
    }

}
