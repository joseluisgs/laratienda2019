<!-- Barra de navegacion -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
        <div class="navbar-header">
            <!-- Colapsar la web en moviles -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src='{{asset('/recursos/laravel-red.png')}}' width='20' alt='logo'/>
            </a>
            <a class="navbar-brand" href="{{ url('/') }}">LaraCRUD SHOP</a>

        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Inicio</a></li>
                <li><a href="{{route('catalogo.index')}}">Catálogo</a></li>
                {{-- Si está autorizado--}}
                @auth
                    @if (Auth::user()->tipo == 'admin')
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <li><a href="{{route('users.index')}}">Usuarios/as</a></li>
                            <li><a href="{{route('productos.index')}}">Productos</a></li>
                            <li><a href="{{route('ventas.index')}}">Ventas</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
                <li><a href="{{route('contacto')}}">Contacto</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {{-- Carrito de compra --}}
                <li>
                    @if (Cart::count()!=0)
                        <a style="color:Tomato" href="{{ route('carrito.index')}}"><span class="glyphicon glyphicon-shopping-cart"></span> {{Cart::count()}}</a>
                    @else
                    <a href="{{ route('carrito.index')}}"><span class="glyphicon glyphicon-shopping-cart"></span> </a>
                    @endif
                </li>
                {{-- Si es un visitante --}}
                @guest

                    <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <li><a href="{{ route('register') }}"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>
                @else
                {{-- Si está autenticado --}}
                    <li><a href='{{ route('home') }}'><img src='{{asset(Auth::user()->imagen)}}' class='avatar img-circle' alt='imagen' width='20' height='20'>  {{ Auth::user()->name }}</a>
                    <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-log-out"></span>
                         {{ __('Logout') }}
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

