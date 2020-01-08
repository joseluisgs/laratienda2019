<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorreoElectronico extends Mailable
{
    use Queueable, SerializesModels;

    // Variable de email
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('laraCRUD@gmail.com.com') // la dirección de donde se envía de la página
                    ->view('mails.correo') // la vista a cargar, podríamos cambiar dependiendo la vista
                    ->text('mails.texto') // el texto de la vista
                    ->with( // Parámetros para esta vista que irá en su texto
                      [
                            'titulo' => 'laraCRUD',
                            'texto' => 'Ejemplo 2º DAWS',
                      ])
                      ->attach(public_path('/recursos').'/laravel-red.png', [ // ficheros adjuntos
                              'as' => 'laravel-red.png',
                              'mime' => 'image/png',
                      ]);
    }
}

