<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Rutas de Administracion
//Rutas que nos lleguen con perfil admin
Route::prefix('admin')->group(function () {
    // Protegemos de usuarios registrados
    // solo los usuarios de tipo admin
    // Rutas automáticas del CRUD de usuarios
    Route::resource('users', 'UsersController')->middleware('perfil:admin', 'auth');
    // Ruta del fichero PDF de usuarios
     Route::get('users-pdf', 'UsersController@pdfAll')->name('users.pdfAll')->middleware('perfil:admin','auth');
     Route::get('users-pdf/{id}', 'UsersController@pdf')->name('users.pdf')->middleware('perfil:admin','auth');

    // Rutas automáticas del CRUD de productos
    Route::resource('productos', 'ProductosController')->middleware('perfil:admin','auth');
    // Ruta del fichero PDF de productos
    Route::get('productos-pdf', 'ProductosController@pdfAll')->name('productos.pdfAll')->middleware('perfil:admin','auth');
    Route::get('producto-pdf/{id}', 'ProductosController@pdf')->name('producto.pdf')->middleware('perfil:admin','auth');

    // Rutas automáticas para el CRUD de Ventas
    Route::resource('ventas', 'VentasController')->middleware('perfil:admin', 'auth');
    Route::get('ventas-pdf', 'VentasController@pdfAll')->name('ventas.pdfAll')->middleware('perfil:admin','auth');
    Route::get('ventas-pdf/{id}', 'VentasController@pdf')->name('ventas.pdf')->middleware('perfil:admin','auth');

});


//Rutas que nos lleguen con perfil catalogo
Route::prefix('catalogo')->group(function () {
    // Pagina principal de nuestro subruta/catalogo
    Route::get('/', 'CatalogoController@index')->name('catalogo.index');//->middleware('auth');
    Route::get('producto/{id}', 'CatalogoController@show')->name('catalogo.show');//->middleware('auth');
});

// Rutas para la parte de autenticación y registro
Auth::routes();
Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::put('actualizar/{id}', 'HomeController@update')->name('home.update');
    Route::get('compras/{id}', 'HomeController@show')->name('home.compra')->middleware('auth');
    Route::get('compras-pdf/{id}', 'HomeController@pdf')->name('home.pdf')->middleware('auth');
});

// Rutas de email
Route::prefix('contacto')->group(function () {
    Route::get('/', 'CorreosController@index')->name('contacto');
    Route::post('enviar', 'CorreosController@enviar')->name('contacto.enviar');;
});

// Rutas del carrito
Route::prefix('carrito')->group(function () {
    // Pagina principal de nuestro subruta/catalogo
    Route::get('/', 'CarritoController@index')->name('carrito.index');//->middleware('auth');
    // Inserta un item en el carrito
    Route::get('insertar/{id}', 'CarritoController@insertar')->name('carrito.insertar');//->middleware('auth');
    // Elimina el producto
    Route::delete('eliminar/{id}', 'CarritoController@eliminar')->name('carrito.eliminar');//->middleware('auth');
    // Actualiza la cantidad del producto
    Route::post('actualizar', 'CarritoController@actualizar')->name('carrito.actualizar');//->middleware('auth');
    // Vacía el carrito de todos sus elementos
    Route::get('vaciar', 'CarritoController@vaciar')->name('carrito.vaciar');//->middleware('auth');
    // Pago del carrito
    Route::get('venta', 'CarritoController@venta')->name('carrito.venta')->middleware('auth');
    // Almacena el carrito
    Route::post('salvar', 'CarritoController@salvar')->name('carrito.salvar')->middleware('auth');
    // Ver Factura
    Route::get('factura/{id}', 'CarritoController@factura')->name('carrito.factura')->middleware('auth');
    // Descarga Factura en PDF
    Route::get('descargar/{id}', 'CarritoController@descargar')->name('carrito.descargar')->middleware('auth');
});
