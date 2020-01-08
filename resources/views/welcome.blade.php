{{-- Extendemos de la clase principal --}}
@extends('template.main')

{{-- pasamos esta parte a todo donde ponga yield con esta eqtiqueta --}}
@section('title', 'LaraCRUD SHOP')

{{-- Inyectamos este contenido en la etiqueta content de su yield --}}
@section('content')
    <!-- Contenido la página web -->
    <div class="jumbotron">
            <h1 class="text-center">¡Bienvenidos/as!</h1>
            <p  class="text-center">Una tienda online hecha con Laravel 5.7 para 2º DAW.</p>
            <p  class="text-center">¡Disfruta de tu compra!</p>
    </div>
@endsection


