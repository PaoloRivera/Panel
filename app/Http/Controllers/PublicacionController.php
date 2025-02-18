<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    // Retorna todas las publicaciones
    public function index()
    {
        return Publicacion::all();
    }

    // Retorna una publicación específica por su ID
    public function show($id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion) {
            return response()->json(['error' => 'Publicación no encontrada.'], 404);
        }

        return $publicacion;
    }

    // Crear una nueva publicación
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_termino' => 'nullable|date',
            'ubicacion' => 'nullable|string|max:255',
            'modalidad' => 'required|in:Presencial,Virtual,Hibrido',
            'estado' => 'required|in:activado,desactivado',
            'remuneracion' => 'nullable|numeric|min:0', // Nueva validación para remuneración
        ]);

        $publicacion = Publicacion::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_termino' => $request->fecha_termino,
            'ubicacion' => $request->ubicacion,
            'modalidad' => $request->modalidad,
            'estado' => $request->estado,
            'remuneracion' => $request->remuneracion, // Guardar remuneración
        ]);

        return response()->json($publicacion, 201);
    }

    // Actualizar una publicación existente
    public function update(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion) {
            return response()->json(['error' => 'Publicación no encontrada.'], 404);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_termino' => 'nullable|date',
            'ubicacion' => 'nullable|string|max:255',
            'modalidad' => 'required|in:Presencial,Virtual,Hibrido',
            'estado' => 'required|in:activado,desactivado',
            'remuneracion' => 'nullable|numeric|min:0', // Nueva validación para remuneración
        ]);

        $publicacion->titulo = $request->titulo;
        $publicacion->descripcion = $request->descripcion;
        $publicacion->fecha_termino = $request->fecha_termino;
        $publicacion->ubicacion = $request->ubicacion;
        $publicacion->modalidad = $request->modalidad;
        $publicacion->estado = $request->estado;
        $publicacion->remuneracion = $request->remuneracion; // Actualizar remuneración

        $publicacion->save();

        return response()->json($publicacion);
    }

    // Eliminar una publicación
    public function destroy($id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion) {
            return response()->json(['error' => 'Publicación no encontrada.'], 404);
        }

        $publicacion->delete();

        return response()->json(['message' => 'Publicación eliminada correctamente.']);
    }
}
