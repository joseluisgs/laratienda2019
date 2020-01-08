<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Librerias adicionales
use Illuminate\Support\Facades\Storage;

use App\Producto;
class CatalogoController extends Controller
{
    /*
     * Devuelve la vista del Catálogo principal, como máximo 6 paginados
    */
    public function index(Request $request)
    {
        // Añadiendole el scope
        $productos = Producto::search($request->name)->orderBy('id', 'ASC')->paginate(6);
        // Se lo pasamos a la vista
        return view('catalogo.index')->with('productos', $productos);
    }

    /**
    * Muestra la ficha de un producto
    */
    public function show($id)
    {
        // Lo localizamos
        $producto = Producto::find($id);
        // Lo mostramos y se lo pasamos a la vista
        return view('catalogo.show')->with('producto', $producto);
    }
}
