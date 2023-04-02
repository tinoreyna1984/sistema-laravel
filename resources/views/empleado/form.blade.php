<h1>{{ $modo }} empleado</h1>

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="form-group">
    <label class="form-label" for="Nombre">Nombre:</label>
    <input class="form-control" type="text" name="Nombre"
        value="{{ isset($empleado->Nombre) ? $empleado->Nombre : old('Nombre') }}" id="Nombre"><br>
    <label class="form-label" for="ApellidoPaterno">Apellido Paterno:</label>
    <input class="form-control" type="text" name="ApellidoPaterno"
        value="{{ isset($empleado->ApellidoPaterno) ? $empleado->ApellidoPaterno : old('ApellidoPaterno') }}"
        id="ApellidoPaterno"><br>
    <label class="form-label" for="ApellidoMaterno">Apellido Materno:</label>
    <input class="form-control" type="text" name="ApellidoMaterno"
        value="{{ isset($empleado->ApellidoMaterno) ? $empleado->ApellidoMaterno : old('ApellidoMaterno') }}"
        id="ApellidoMaterno"><br>
    <label class="form-label" for="Correo">Correo:</label>
    <input class="form-control" type="email" name="Correo"
        value="{{ isset($empleado->Correo) ? $empleado->Correo : old('Correo') }}" id="Correo"><br>
    <div class="d-flex flex-column mb-4">
        @if (isset($empleado->Foto))
            <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $empleado->Foto }}" width="120"
                alt="foto">
        @endif
        <input class="form-control" type="file" name="Foto" value="" id="Foto">
    </div>
    <input class="btn btn-success" type="submit" value="{{ $modo }} datos">
    <a class="btn btn-secondary" href="{{ url('empleado') }}">Regresar</a>
</div>
