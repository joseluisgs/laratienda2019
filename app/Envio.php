<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    // La tabla
    protected $table= "envios";

    // Los campos requeridos
    protected $fillable = [
        'nombre', 'direccion', 'ciudad', 'provincia', 'codigoPostal',
        'telefono', 'email', 'venta_id'
    ];
    // Vamos a hacer las relaciones mapeándolas
    // Un Envío pertenece a una venta
    public function venta()
    {
        return $this->belongsTo('App\Venta');
    }
}
