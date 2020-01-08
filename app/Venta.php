<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
    // La tabla
    protected $table= "ventas";

    // Los campos requeridos
    protected $fillable = [
        'codigo', 'fecha','total', 'subtotal', 'iva', 'user_id'
    ];

    // Vamos a hacer las relaciones mapeándolas
    // Una venta pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }

    // Una venta tiene un pago
    public function pago()
    {
        return $this->hasOne('App\Pago');
    }

    // Una venta tiene un envio
    public function venta()
    {
        return $this->hasOne('App\Envio');
    }

    // Una venta tiene muchas lineas de ventas
    public function lineas()
    {
        return $this->hasMany('App\LineaVenta');
    }
}
