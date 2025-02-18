<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Docente; // Asegúrate de importar el modelo Docente si no lo has hecho.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarreraController extends Controller
{
    /**
     * Retorna todas las carreras.
     */
    public function index()
    {
        return Carrera::all();
    }

    /**
     * Retorna una carrera específica por su ID.
     */
    public function show($id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json(['error' => 'Carrera no encontrada.'], 404);
        }

        return $carrera;
    }

    /**
     * Crear una nueva carrera.
     */
    public function store(Request $request)
    {
        // Validación incluyendo el campo 'id_docente'
        $request->validate([
            'titulo' => 'required|string|max:255',
            'foto' => 'nullable|file|image|max:2048',
            'descripcion' => 'nullable|string',
            'contenido_titulo' => 'nullable|string',
            'contenido_subtitulo' => 'nullable|string',
            'modalidad' => 'required|in:Presencial,Virtual,Hibrido',
            'fecha_inicio' => 'required|date',
            'horario' => 'nullable|string',
            'valor_academico' => 'required|integer',
            'costo' => 'required|numeric',
            'video' => 'nullable|url',
            'id_docente' => 'required|exists:docentes,id',  // Validación de docente
        ]);

        // Guardar la foto si se sube un archivo
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('carreras', 'public');
        }

        // Crear la carrera con los nuevos datos
        $carrera = Carrera::create([
            'titulo' => $request->titulo,
            'foto' => $fotoPath,
            'descripcion' => $request->descripcion,
            'contenido_titulo' => $request->contenido_titulo,
            'contenido_subtitulo' => $request->contenido_subtitulo,
            'modalidad' => $request->modalidad,
            'fecha_inicio' => $request->fecha_inicio,
            'horario' => $request->horario,
            'valor_academico' => $request->valor_academico,
            'costo' => $request->costo,
            'video' => $request->video,
            'id_docente' => $request->id_docente,  // Relación con docente
        ]);

        return response()->json($carrera, 201);
    }

    /**
     * Actualizar una carrera existente.
     */
    public function update(Request $request, $id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json(['error' => 'Carrera no encontrada.'], 404);
        }

        // Validación incluyendo el campo 'id_docente'
        $request->validate([
            'titulo' => 'required|string|max:255',
            'foto' => 'nullable|file|image|max:2048',
            'descripcion' => 'nullable|string',
            'contenido_titulo' => 'nullable|string',
            'contenido_subtitulo' => 'nullable|string',
            'modalidad' => 'required|in:Presencial,Virtual,Hibrido',
            'fecha_inicio' => 'required|date',
            'horario' => 'nullable|string',
            'valor_academico' => 'required|integer',
            'costo' => 'required|numeric',
            'video' => 'nullable|url',
            'id_docente' => 'required|exists:docentes,id',  // Validación de docente
        ]);

        // Eliminar la foto anterior si se sube una nueva
        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($carrera->foto);
            $fotoPath = $request->file('foto')->store('carreras', 'public');
            $carrera->foto = $fotoPath;
        }

        // Actualizar los demás campos
        $carrera->titulo = $request->titulo;
        $carrera->descripcion = $request->descripcion;
        $carrera->contenido_titulo = $request->contenido_titulo;
        $carrera->contenido_subtitulo = $request->contenido_subtitulo;
        $carrera->modalidad = $request->modalidad;
        $carrera->fecha_inicio = $request->fecha_inicio;
        $carrera->horario = $request->horario;
        $carrera->valor_academico = $request->valor_academico;
        $carrera->costo = $request->costo;
        $carrera->video = $request->video;
        $carrera->id_docente = $request->id_docente;  // Actualización de la relación docente

        $carrera->save();

        return response()->json($carrera);
    }

    /**
     * Eliminar una carrera.
     */
    public function destroy($id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json(['error' => 'Carrera no encontrada.'], 404);
        }

        // Eliminar la foto asociada
        if ($carrera->foto) {
            Storage::disk('public')->delete($carrera->foto);
        }

        $carrera->delete();

        return response()->json(['message' => 'Carrera eliminada correctamente.']);
    }
}
