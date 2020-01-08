<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Librerias adicionales
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;

// Importamos el modelo
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Listado sin buscador
        //$users = User::orderBy('id', 'ASC')->paginate(2);
        // sin scope
        //$users = User::where('name', 'LIKE', "%$request->name%" )->orderBy('id', 'ASC')->paginate(2);
        // añadiendole el scope
        $users = User::search($request->name)->orderBy('id', 'ASC')->paginate(2);
        // Se lo pasamos a la vista
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'name'=>'min:4|max:120|required',
            'email'=> 'min:4|max:250|required|unique:users',
            'password' => 'min:4|max:120:required',
            'imagen' => 'required'
        ]);
        try{
            // Creamos el objeto
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
            // Copiamos la imagen y obtenemos su path
            $user->imagen = $request->file('imagen')->store('storage');
            // Salvamos en la BD
            $user->save();
            flash('Usuario/a '. $user->name.'  creado con éxito.')->success()->important();
            return redirect()->route('users.index'); // Volvemos a la vista
        }catch(\Exception $e){
            flash('Error al crear el Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back(); // volvemos a la anterior
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lo localizamos
        $user = User::find($id);
        // Lo mostramos y se lo pasamos a la vista
        return view('admin.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Lo localizamos
        $user = User::find($id);
        // Lo pasamos a la vista, pero esta vez con un metodo alternativo
        // es decir, para pasar varios parámetros un array asociativo
        // ideal si pasamos varios parámetros
        return view('admin.users.edit', ['user'=>$user]); //->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validamos los datos
        $request->validate([
            'name'=>'min:4|max:120|required',
            'email'=> 'min:4|max:250|required',
        ]);
        try{
             // Lo encontramos
            $user = User::find($id);
            // Lo actualizamos
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->tipo= $request->tipo;
            // Si ha cambiado la imagen y existe la antigua
            if($request->imagen){
                // la borramos si existe
                if(Storage::exists($user->imagen)){
                    Storage::delete($user->imagen);
                }
                // Copiamos la imagen y obtenemos su path
                $user->imagen = $request->file('imagen')->store('storage');
            }
            // Salvamos (actualizamos) en la BD
            $user->save();
            flash('Usuario/a '. $user->name.'  modificado/a con éxito.')->warning()->important();
            return redirect()->route('users.index');
        }catch(\Exception $e){
            flash('Error al modificar el Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            // Localizamos y creamos el objeto
            $user = User::find($id);
            //borramos su imagen
            if(Storage::exists($user->imagen)){
                Storage::delete($user->imagen);
            }
            //borramos el usuario de la BD
            $user->delete();
            flash('Usuario/a '. $user->name.'  eliminado/a con éxito.')->error()->important();
            return redirect()->route('users.index');
        }catch(\Exception $e){
            flash('Error al eliminar Usuario/a '. $user->name.'.'.$e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Crea una vista en PDF con los datos de los usuarios
     */
    public function pdfAll()
    {
        // Obtenemos todos los datos
        $users = User::all();
        // creamos la vista
        $pdf = PDF::loadView('pdf.users', compact('users'));
        // Creamos el nombre del fichero e iniciamos su descarga
        $fichero = 'usuarios-'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
    /**
     * Crea una vista en PDF con los datos de un usuario
     */
    public function pdf($id)
    {
        // Lo localizamos
        $user = User::find($id);
        // creamos la vista
        $pdf = PDF::loadView('pdf.user', compact('user'));
        //Creamos el nombre del fichero e iniciamos su descarga
        $fichero = 'usuario-'.date("YmdHis").'.pdf';
        return $pdf->download($fichero);
    }
}
