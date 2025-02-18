<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstudiantesController extends Controller
{
    /**
     * Retorna todos los estudiantes.
     */
    public function index()
    {
        return Estudiante::all();
    }

    /**
     * Retorna un estudiante específico por su DNI.
     */
    public function show($dni)
    {
        $estudiante = Estudiante::find($dni);

        if (!$estudiante) {
            return response()->json(['error' => 'Estudiante no encontrado.'], 404);
        }

        return $estudiante;
    }

    /**
     * Crear un nuevo estudiante.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:20|unique:estudiantes,dni',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'cv' => 'required|file|mimes:pdf|max:2048', // Validación para el CV
        ]);

        // Guardar el archivo PDF en el disco público
        $cvPath = $request->file('cv')->store('cv_estudiantes', 'public');

        // Crear el estudiante con la ruta del archivo CV
        $estudiante = Estudiante::create([
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'cv' => $cvPath,
        ]);

        return response()->json($estudiante, 201);
    }

    /**
     * Actualizar un estudiante existente.
     */
    public function update(Request $request, $dni)
    {
        $estudiante = Estudiante::find($dni);

        if (!$estudiante) {
            return response()->json(['error' => 'Estudiante no encontrado.'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Verificar si se subió un archivo nuevo
        if ($request->hasFile('cv')) {
            // Eliminar el archivo CV anterior
            Storage::disk('public')->delete($estudiante->cv);

            // Guardar el nuevo archivo PDF
            $cvPath = $request->file('cv')->store('cv_estudiantes', 'public');
            $estudiante->cv = $cvPath;
        }

        // Actualizar los otros campos
        $estudiante->nombre = $request->nombre;
        $estudiante->apellidos = $request->apellidos;
        $estudiante->correo = $request->correo;
        $estudiante->telefono = $request->telefono;
        $estudiante->save();

        return response()->json($estudiante);
    }

    /**
     * Eliminar un estudiante.
     */
    public function destroy($dni)
    {
        $estudiante = Estudiante::find($dni);

        if (!$estudiante) {
            return response()->json(['error' => 'Estudiante no encontrado.'], 404);
        }

        // Eliminar el archivo CV asociado
        Storage::disk('public')->delete($estudiante->cv);

        $estudiante->delete();

        return response()->json(['message' => 'Estudiante eliminado correctamente.']);
    }
}
