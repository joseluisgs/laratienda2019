<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;

class Producto extends Model implements Buyable
{
    // La tabla
    protected $table= "productos";
    // Los campos requeridos
    protected $fillable = [
        'marca', 'modelo', 'precio','tipo', 'stock','imagen'
    ];

    // scope para el buscador de producto
    public function scopeSearch($query, $name){
        return $query->where('modelo', 'LIKE', "%$name%" )->orWhere('marca', 'LIKE', "%$name%");
    }

    // Interfaz Buyable
    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }

    public function getBuyableDescription($options = null) {
        return $this->modelo;
    }

    public function getBuyablePrice($options = null) {
        return $this->precio;
    }

    // Un producto puede estar en muchas líneas
    public function lineas()
    {
        return $this->hasMany('App\LineaVenta');
    }
}
