<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos["empleados"] = Empleado::paginate(5); // tomamos los empleados del modelo Empleado y aparecerán 5 registros por página
        return view('empleado.index', $datos); // enviamos los datos al index de la vista de empleado
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // criterios de validación previa de los campos
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'Foto' => 'required|max:10000|mimes:jpg,jpeg,png',
        ];
        $mensajes = [
            'required' => 'El :attribute es requerido',
            'Foto.required' => 'La foto es requerida',
        ];

        // valida el request
        $this->validate($request, $campos, $mensajes);

        // toma todos los valores del request excepto el token
        $datosEmpleado = $request->except('_token');
        if ($request->hasFile('Foto')) { // si existe, almacena la foto
            $datosEmpleado['Foto'] = $request->file(('Foto'))->store('uploads', 'public');
        }
        Empleado::insert($datosEmpleado); // inserta en tabla

        //return response()->json($datosEmpleado);
        return redirect('empleado')->with('mensaje', 'Empleado agregado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // criterios de validación previa de los campos
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
        ];
        $mensajes = [
            'required' => 'El :attribute es requerido',
        ];
        // valida el request
        if ($request->hasFile('Foto')) { // si se desea cambiar la foto
            $campos = [
                'Foto' => 'required|max:10000|mimes:jpg,jpeg,png',
            ];
            $mensajes = [
                'Foto.required' => 'La foto es requerida',
            ];
        }
        $this->validate($request, $campos, $mensajes);

        //
        $datosEmpleado = $request->except('_token', '_method');
        if ($request->hasFile('Foto')) { // si existe, almacena la foto
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/' . $empleado->Foto);
            $datosEmpleado['Foto'] = $request->file(('Foto'))->store('uploads', 'public');
        }
        Empleado::where('id', '=', $id)->update($datosEmpleado);
        $empleado = Empleado::findOrFail($id);
        //return view('empleado.edit', compact('empleado'));
        return redirect('empleado')->with('mensaje', 'Empleado actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $empleado = Empleado::findOrFail($id);
        if (Storage::delete('public/' . $empleado->Foto)) {
            Empleado::destroy($id);
        }
        //return redirect('empleado');
        return redirect('empleado')->with('mensaje', 'Empleado eliminado exitosamente');
    }

    /**
     * Get all rows for an API REST call
     * Only this method should be exposed on the middleware publicly
     *
     * TFRC addition 20230401
     */
    public function getEmpleados(){
        return response()->json(Empleado::all(), 200);
    }
}
