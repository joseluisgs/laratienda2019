<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Librerias adicionales

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;


use App\Producto;
class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Añadiendole el scope
        $productos = Producto::search($request->name)->orderBy('id', 'ASC')->paginate(2);
        // Se lo pasamos a la vista
        return view('admin.productos.index')->with('productos', $productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'marca'=>'min:4|max:120|required',
            'modelo'=> 'min:4|max:250|required',
            'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
            'stock'=> 'min:1|max:100|required',
            'imagen' => 'required'
        ]);
        try{
            // Creamos el objeto
            $producto = new Producto($request->all());
            // Copiamos la imagen y obtenemos su path
            $producto->imagen = $request->file('imagen')->store('storage');
            // Salvamos en la BD
            $producto->save();
            flash('Producto '. $producto->modelo.'  creado con éxito.')->success()->important();
            return redirect()->route('productos.index'); // Volvemos a la vista
        }catch(\Exception $e){
            flash('Error al crear el Producto'. $producto->modelo.'.'.$e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
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
        // Lo localizamos
        $producto = Producto::find($id);
        // Lo mostramos y se lo pasamos a la vista
        return view('admin.productos.show')->with('producto', $producto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Lo localizamos
        $producto = Producto::find($id);
        // Lo pasamos a la vista, pero esta vez con un metodo alternativo
        // es decir, para pasar varios parámetros un array asociativo
        // ideal si pasamos varios parámetros
        return view('admin.productos.edit', ['producto'=>$producto]); //->with('user', $user);
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
         //Validamos los datos
         $request->validate([
            'marca'=>'min:4|max:120|required',
            'modelo'=> 'min:4|max:250|required',
            'precio' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/',
            'stock'=> 'min:1|max:100|required',
        ]);
        try{
             // Lo encontramos
            $producto = Producto::find($id);
            // Lo actualizamos
            $producto->marca = $request->marca;
            $producto->modelo = $request->modelo;
            $producto->precio = $request->precio;
            $producto->tipo= $request->tipo;
            $producto->stock =$request->stock;
            // Si ha cambiado la imagen y existe la antigua
            if($request->imagen){
                // la borramos si existe
                if(Storage::exists($producto->imagen)){
                    Storage::delete($producto->imagen);
                }
                // Copiamos la imagen y obtenemos su path
                $producto->imagen = $request->file('imagen')->store('storage');
            }
            // Salvamos (actualizamos) en la BD
            $producto->save();
            flash('Producto '. $producto->modelo. '  modificado/a con éxito.')->warning()->important();
            return redirect()->route('productos.index');
        }catch(\Exception $e){
            flash('Error al modificar el Producto '. $producto->modelo.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
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
            $producto = Producto::find($id);
            //borramos su imagen
            if(Storage::exists($producto->imagen)){
                Storage::delete($producto->imagen);
            }
            //borramos el usuario de la BD
            $producto->delete();
            flash('Producto '. $producto->modelo.'  eliminado/a con éxito.')->error()->important();
            return redirect()->route('productos.index');
        }catch(\Exception $e){
            flash('Error al eliminar Usuario/a '. $producto->modelo.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Crea una vista en PDF con los datos de los productos
     */
    public function pdfAll()
    {
        // Obtenemos todos los datos
        $productos = Producto::all();
        // creamos la vista
        $pdf = PDF::loadView('pdf.productos', compact('productos'));
        // Creamos el nombre del fichero e iniciamos su descarga
        $fichero = 'productos-'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
    /**
     * Crea una vista en PDF con los datos de un producto
     */
    public function pdf($id)
    {
        // Lo localizamos
        $producto = Producto::find($id);
        // creamos la vista
        $pdf = PDF::loadView('pdf.producto', compact('producto'));
        //Creamos el nombre del fichero e iniciamos su descarga
        $fichero = 'producto'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
}
