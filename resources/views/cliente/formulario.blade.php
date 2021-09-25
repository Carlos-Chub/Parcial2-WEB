<h1>{{ $modo }} cliente</h1>

<!--Si hay algun error-->
@if(count($errors)>0)
    <!--Imprimir estos mensajes-->
    <div class="alert alert-danger" role="alert">
        <ul>
            <!--Recorrer cada uno de los errores y mostrarlos-->
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>    
            @endforeach
        </ul>
    </div>
    
@endif

<div class="form-group">
    <label for="Nombre">Nombres</label>
    <!--Para recuperar informacion que se ha escrito, para eso se utiliza el old-->
    <input type="text" class="form-control" name="Nombre" value="{{ isset($cliente->Nombre)?$cliente->Nombre:old('Nombre') }}" id="Nombre">
</div>

<div class="form-group">
    <label for="Apellido1">Apellido Paterno</label>
    <input type="text" class="form-control" name="Apellido1" value="{{ isset($cliente->Apellido1)?$cliente->Apellido1:old('Apellido1') }}" id="Apellido1">
</div>

<div class="form-group">
    <label for="Apellido2">Apellido Materno</label>
    <input type="text" class="form-control" name="Apellido2" value="{{ isset($cliente->Apellido2)?$cliente->Apellido2:old('Apellido2') }}" id="Apellido2">
</div>

<div class="form-group">
    <label for="Telefono">Telefono</label>
    <input type="text" class="form-control" name="Telefono" value="{{ isset($cliente->Telefono)?$cliente->Telefono:old('Telefono') }}" id="Telefono">
</div>

<div class="form-group">
    <label for="Correo">Correo</label>
    <input type="text" class="form-control" name="Correo" value="{{ isset($cliente->Correo)?$cliente->Correo:old('Correo') }}" id="Correo">
</div>
<!--Todo lo relacionado a la imagen cuando se quiere editar-->
<div class="form-group">
    <label for="Foto"></label>
    <!---->
    @if(isset($cliente->Foto)) <!--Si existe algo en la variable empleado-->
    <!--En src se coloca la ruta de la imagen, se recupera desde storage-->
        <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$cliente->Foto }}" width="100" alt="">
    @endif
    <input type="file" class="form-control" name="Foto" value="" id="Foto">
</div>

<input class="btn btn-success" type="submit" value="{{ $modo }} datos">
 <!--Boton para regresar a cliente, es decir a index.php-->
<a class="btn btn-primary" href="{{ url('cliente/') }}">Regresar</a>

<br>