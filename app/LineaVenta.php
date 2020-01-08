<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineaVenta extends Model
{
    // La tabla
    protected $table= "linea_ventas";

    // Los campos requeridos
    protected $fillable = [
        'venta_id', 'producto', 'precio', 'cantidad', 'total'
    ];

    // Una línea de venta pertenece a una venta
    public function venta()
    {
        return $this->belongsTo('App\Venta');
    }

    // Una línea de venta tine un producto
    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }
}
