@extends('layouts.app')
@section('content')
<div class="container">
<!--Mostrar mensaje de validaciones-->
<!--Si se agrego un registro o se edito-->
@if(Session::has('mensaje'))
    <!-- Mostrar el mensaje cuando se ha modificado eliminado o creado -->
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('mensaje') }}
        <!--Boton para cerrar el mensaje de alerta u ocultar-->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

    
<!--Para agregar un nuevo cliente - boton de tipo referencia-->
<a href="{{ url('cliente/create') }}" class="btn btn-success" >Registrar nuevo cliente</a>
<br/>
<br/>
<!--Tabla para mostrar los datos de la base de datos-->
<table class="table table-info table-hover">
    <thead class="table-dark">
        <!--Encabezado de la tabla-->
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombres</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <!--Desplegar el contenido de la tabla-->
    <tbody>
        <!--Ciclo para recorrer cada uno de los registros, el contenido de la variable clientes lo pasa a empleado-->
        @foreach($clientes as $cliente)
        <tr>
            <!--Mostrar el id del cliente-->
            <td>{{ $cliente->id }}</td>
            <!--Para mostrar la imagen-->
            <!--En src se coloca la ruta de la imagen, se recupera desde storage-->
            <td>
                <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$cliente->Foto }}" width="100" alt="">
            </td>
            <!--Mostrar lo demas-->
            <td>{{ $cliente->Nombre }}</td>
            <td>{{ $cliente->Apellido1 }}</td>
            <td>{{ $cliente->Apellido2 }}</td>
            <td>{{ $cliente->Telefono }}</td>
            <td>{{ $cliente->Correo }}</td>
            <td>
            <!--Mostrar acciones, boton editar y eliminar-->

             <!--Objeto a para que nos lleve al formulario de editar-->
              <!--al irse a la ruta de editar se el enviar el id ($cliente->id.'/edit) al formulario editar.php-->
            <a href="{{ url('/cliente/'.$cliente->id.'/edit') }}" class="btn btn-warning">
                Editar
            </a>    
             |
                <!--Borrar un empleado o registro-->
                <!--En action se envia a cliente(index) pero conjuntamente con el id($cliente->id)-->
                <form action="{{ url('/cliente/'.$cliente->id) }}" class="d-inline" method="post">
                     <!--LLave de seguridad para llevar a cabo la accion-->
                    @csrf
                     <!--Para eliminar se utiliza el metodo DELETE no post-->
                    {{ method_field('DELETE') }}
                    <!--Boton eliminar o borrar, con un mensaje de quieres borrar?-->
                    <input class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres borrar?')" value="Borrar">

                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!--Mostrar la paginacion de 1 que se ha declarado en cliente controller y appServiceProvider.-->
{!! $clientes->links() !!}
</div>
@endsection