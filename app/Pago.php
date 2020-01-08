<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    // La tabla
    protected $table= "pagos";

    // Los campos requeridos
    protected $fillable = [
        'titular', 'tipo', 'numero', 'cvv', 'mes', 'año', 'venta_id'
    ];
    // Vamos a hacer las relaciones mapeándolas
    // Un Pago pertenece a una venta
    public function venta()
    {
        return $this->belongsTo('App\Venta');
    }
}
