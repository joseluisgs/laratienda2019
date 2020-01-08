<h1>Formulario de Contacto.</h1>
<p>{{ $email->receptor }}, se has puesto en contacto contigo</u></p>

<p><u>Contenido:</u></p>

<p><b>Nombre del proyecto:</b>&nbsp;{{ $titulo }}</p>
<p><b>Curso:</b>&nbsp;{{ $texto }}</p>

<div>
<p><b>Nombre:</b>&nbsp;{{ $email->nombre }}</p>
<p><b>Comentario:</b>&nbsp;{{ $email->comentario }}</p>
<p><b>Su correo:</b>&nbsp;{{ $email->correo }}</p>
</div>

Muchas gracias,
<br/>
<i>{{ $email->emisor }}</i>
