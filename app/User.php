<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Nombre de la tabla puesta en su migración en Schema
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // Ponemos los campos a recuperar
    protected $fillable = [
        'name', 'email', 'password','tipo','imagen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     // scope para el buscador de usuario
    public function scopeSearch($query, $name){
        return $query->where('name', 'LIKE', "%$name%" );
    }

    // Relaciones con ventas
    // Un usuario tiene muchas ventas
    public function ventas()
    {
        return $this->hasMany('App\Venta');
    }

}
