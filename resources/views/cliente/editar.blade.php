@extends('layouts.app')
@section('content')
<div class="container">
<!--Nos posicionamos en cliente pero con el id-->
<!--Como se esta trabajando cona archivos de imagen agregar enctype-->
<form method="post" action="{{ url('/cliente/'.$cliente->id) }}" enctype="multipart/form-data">
    <!--LLave para llevar a cabo la accion editar-->
    @csrf
    <!--para actualizar no se utiliza el metodo post por lo que se usa PATCH-->
    {{ method_field('PATCH') }}
    <!--Se incluye todo lo que contiene form.php (textboxs) mas un mensaje "Editar"-->
    @include('cliente.formulario',['modo'=>'Editar']);
</form>
</div>
@endsection

