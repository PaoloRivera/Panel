<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use App\Models\Publicacion;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    // Retorna todas las postulaciones
    public function index()
    {
        return Postulacion::with(['publicacion', 'estudiante'])->get();
    }

    // Retorna una postulación específica por su ID
    public function show($id)
    {
        $postulacion = Postulacion::with(['publicacion', 'estudiante'])->find($id);

        if (!$postulacion) {
            return response()->json(['error' => 'Postulación no encontrada.'], 404);
        }

        return $postulacion;
    }

    // Crear una nueva postulación
    public function store(Request $request)
    {
        $request->validate([
            'id_publicacion' => 'required|exists:publicaciones,id',
            'dni_estudiante' => 'required|exists:estudiantes,dni',
            'fecha' => 'required|date',
            'estado' => 'required|in:activado,desactivado',
            'comentarios' => 'nullable|string',
        ]);

        $postulacion = Postulacion::create([
            'id_publicacion' => $request->id_publicacion,
            'dni_estudiante' => $request->dni_estudiante,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'comentarios' => $request->comentarios,
        ]);

        return response()->json($postulacion, 201);
    }

    // Actualizar una postulación existente
    public function update(Request $request, $id)
    {
        $postulacion = Postulacion::find($id);

        if (!$postulacion) {
            return response()->json(['error' => 'Postulación no encontrada.'], 404);
        }

        $request->validate([
            'id_publicacion' => 'required|exists:publicaciones,id',
            'dni_estudiante' => 'required|exists:estudiantes,dni',
            'fecha' => 'required|date',
            'estado' => 'required|in:activado,desactivado',
            'comentarios' => 'nullable|string',
        ]);

        $postulacion->id_publicacion = $request->id_publicacion;
        $postulacion->dni_estudiante = $request->dni_estudiante;
        $postulacion->fecha = $request->fecha;
        $postulacion->estado = $request->estado;
        $postulacion->comentarios = $request->comentarios;

        $postulacion->save();

        return response()->json($postulacion);
    }

    // Eliminar una postulación
    public function destroy($id)
    {
        $postulacion = Postulacion::find($id);

        if (!$postulacion) {
            return response()->json(['error' => 'Postulación no encontrada.'], 404);
        }

        $postulacion->delete();

        return response()->json(['message' => 'Postulación eliminada correctamente.']);
    }
}
