Hola {{ $email->receptor }},

Mostraré valores pasados por with y email.

Contenido de tu correo:

-Nombre del proyecto:{{ $titulo }}.
-Curso:{{ $texto }}.

-Nombre:{{ $email->nombre }}.
-Comentario{{ $email->comentario }}.

Muchas gracias,
{{ $email->emisor }}
