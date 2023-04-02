@extends('layouts.app')

@section('content')
    <div class="container">

        @if (Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <a class="btn btn-primary" href="{{ url('empleado/create') }}">Registrar nuevo empleado</a>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $empleado)
                    <tr>
                        <th>{{ $empleado->id }}</th>
                        <th>
                            <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $empleado->Foto }}"
                                width="120" alt="foto">
                        </th>
                        <th>{{ $empleado->Nombre }}</th>
                        <th>{{ $empleado->ApellidoPaterno }}</th>
                        <th>{{ $empleado->ApellidoMaterno }}</th>
                        <th>{{ $empleado->Correo }}</th>
                        <th>
                            <a class="btn btn-secondary" href="{{ url('/empleado/' . $empleado->id . '/edit') }}">Editar</a>
                            <form class="d-inline" action="{{ url('/empleado/' . $empleado->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <input class="btn btn-danger" type="submit"
                                    onclick="return confirm('¿Realmente deseas borrar?')" value="Borrar">
                            </form>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $empleados->links() !!}
    </div>
@endsection
