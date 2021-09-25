@extends('layouts.app')
@section('content')
<div class="container">

<!--enctype este sirve para poder enviar archivos o fotos mediante el metodo post-->
<!--action y lo que tiene como valor es el lugar a donde se envian esos datos-->
<form action="{{ url('/cliente') }}" method="post" enctype="multipart/form-data">
    <!--Se genera una llave de seguridad para hacer la accion, por cuestiones de seguridad-->
    @csrf
     <!--Llamar al codigo html que corresponde a los campos para la creacion del cliente (form.php) mas un mensaje "Crear"
        Este mensaje se mostrara en los botones-->
    @include('cliente.formulario',['modo'=>'Registrar']);

</form>
</div>
@endsection

