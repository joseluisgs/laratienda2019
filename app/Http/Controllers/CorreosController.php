<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\CorreoElectronico;
use Illuminate\Support\Facades\Mail;

class CorreosController extends Controller
{
    // Funcion de enviar
    public function enviar(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'nombre'=>'min:4|max:120|required',
            'correo'=> 'min:4|max:250|required',
            'comentario' => 'min:4|max:120:required',
        ]);
        $email = new \stdClass(); // clase dinámica
        $email->nombre = $request->nombre;
        $email->comentario = $request->comentario;
        $email->emisor = 'LaraCRUD';
        $email->receptor = $request->nombre;
        $email->correo = $request->correo;

        // Me lo mando a la dirección para recibirlo
        // Tambié le podríamos mandar una copia al emisor
        Mail::to("xxxxxxx@xxxxx.com")->send(new CorreoElectronico($email));
        flash('Correo electrónico de '. $email->nombre.'  enviado con éxito.')->success()->important();
        //return redirect()->route(''); // Volvemos a la vista
        return view('mails.contacto');
    }

    public function index()
    {
        return view('mails.contacto');
    }
}
