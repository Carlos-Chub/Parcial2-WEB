<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
//CLASE PARA PODER HACER EL BORRADO DE LA FOTO EN EL STORAGE, EN CASO DE YA EXISTIR
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $datos['clientes'] = Cliente::paginate(1);
        //Le pasamos los datos de la consulta a la vista o template index.php
        return view('cliente.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('cliente.insertar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Campos a validar, mediante un arreglo
        $campos=[
            //Nombre, es un campo requerido, sea string y que tenga un maximo de 100 lineas
            'Nombre'=>'required|string|max:100',
            'Apellido1'=>'required|string|max:100',
            'Apellido2'=>'required|string|max:100',
            'Telefono'=>'required|string|max:12',
            'Correo'=>'required|string|max:100',
            //Requerido, que tenga un maximo de 1000px y solo acepta 3 formatos
            'Foto'=>'required|max:10000|mimes:jpeg,png,jpg',
        ];
        //Mensajes de error al usuario a mostrar
        $mensaje=[
            //Todos los que tienen require mostrara el msj sino se cumple
            'required'=>'El :attribute es requerido',
            //si no agrego foto
            'Foto.required'=>'La foto es requerida'
        ];

        //Como unir los campos y los mensajes, request es todo lo que se envie, que valide campos y muestre mensajes
        $this->validate($request, $campos, $mensaje);

        //INSERCION DE DATOS A LA BASE DE DATOS

        //Obtener todos los datos excepto el campo token(csrf que se genero en el create)
        $datosCliente = request()->except('_token');
        //si hay fotografia vamos a alterar el nombre del archivo y adjuntarlo a nuestro sistema o proyecto
        if($request->hasFile('Foto')){
            //Obtener la foto e insertarlo en el storage, en la carpeta uploads en public
            $datosCliente['Foto']=$request->file('Foto')->store('uploads','public');
        }
        //Insertar toda la informacion obtenida en la base de datos para un nuevo registro
        Cliente::insert($datosCliente);

        //return response()->json($datosEmpleado);
        //Regresar a la ruta cliente mostrando un msj de que se agreado un nuevo cliente
        return redirect('cliente')->with('mensaje','Cliente agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Se obtiene el id del cliente
        $cliente=Cliente::findOrFail($id);
        //Pasarle el id al formulario para que se muestre los datos del cliente
        return view('cliente.editar', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validacion de campos
        $campos=[
            'Nombre'=>'required|string|max:100',
            'Apellido1'=>'required|string|max:100',
            'Apellido2'=>'required|string|max:100',
            'Telefono'=>'required|string|max:12',
            'Correo'=>'required|string|max:100',
        ];
        //Mensaje en relacion a los campos requeridos
        $mensaje=[
            'required'=>'El :attribute es requerido',
        ];
        //Si la foto ya existe
        if($request->hasFile('Foto')){
            $campos=['Foto'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensaje=['Foto.required'=>'La foto es requerida'];
        }

        $this->validate($request, $campos, $mensaje);

        //PARA ACTUALIZAR UN REGISTRO

        //Obtiene todos los datos del cliente excepto el token y el method
        $datosCliente = request()->except('_token', '_method');

        //si hay fotografia vamos a alterar el nombre del archivo, o reemplazarlo por otro
        if($request->hasFile('Foto')){
            //Se recupera la informacion de la foto anterior
            $cliente=Cliente::findOrFail($id);
            //En caso de ya existir se hace el borrado de la foto antigua
            Storage::delete('public/'.$cliente->Foto);
            //Guardar en el storage la nueva foto, si hay cambio
            $datosCliente['Foto']=$request->file('Foto')->store('uploads','public');
        }
        //Para actualizar el cliente mediante su id
        tbproducto::where('id','=',$id)->update($datosCliente);

        //Recuperar el id
        $cliente=Cliente::findOrFail($id);
        //
        return redirect('cliente')->with('mensaje', 'Cliente actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Obtenemos el id del cliente
        $cliente=Cliente::findOrFail($id);
        //preguntar si la fotografia existe, de existir borrar la fotografia sino solo borra registro
        if(Storage::delete('public/'.$cliente->Foto)){
            //ELIMINAR UN REGISTRO DE LA BASE DE DATOS CON EL ID RECIBIDO
            Cliente::destroy($id);
        }
        //Regresar a la url de cliente
        return redirect('cliente')->with('mensaje', 'Cliente Eliminado');
    }
}
