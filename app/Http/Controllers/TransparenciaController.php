<?php

namespace App\Http\Controllers;

use App\Models\Transparencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransparenciaController extends Controller
{
    /**
     * Retorna todas las transparencias.
     */
    public function index()
    {
        return Transparencia::all();
    }

    /**
     * Retorna una transparencia específica por su ID.
     */
    public function show($id)
    {
        $transparencia = Transparencia::find($id);

        if (!$transparencia) {
            return response()->json(['error' => 'Transparencia no encontrada.'], 404);
        }

        return $transparencia;
    }

    /**
     * Crear una nueva transparencia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Guardar el archivo PDF en el disco público
        $pdfPath = $request->file('pdf')->store('transparencias', 'public');

        // Crear la transparencia con la ruta del archivo PDF
        $transparencia = Transparencia::create([
            'titulo' => $request->titulo,
            'pdf' => $pdfPath,
        ]);

        return response()->json($transparencia, 201);
    }

    /**
     * Actualizar una transparencia existente.
     */
    public function update(Request $request, $id)
    {
        $transparencia = Transparencia::find($id);

        if (!$transparencia) {
            return response()->json(['error' => 'Transparencia no encontrada.'], 404);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Verificar si se subió un archivo nuevo
        if ($request->hasFile('pdf')) {
            // Eliminar el archivo PDF anterior
            Storage::disk('public')->delete($transparencia->pdf);

            // Guardar el nuevo archivo PDF
            $pdfPath = $request->file('pdf')->store('transparencias', 'public');
            $transparencia->pdf = $pdfPath;
        }

        // Actualizar el título
        $transparencia->titulo = $request->titulo;
        $transparencia->save();

        return response()->json($transparencia);
    }

    /**
     * Eliminar una transparencia.
     */
    public function destroy($id)
    {
        $transparencia = Transparencia::find($id);

        if (!$transparencia) {
            return response()->json(['error' => 'Transparencia no encontrada.'], 404);
        }

        // Eliminar el archivo PDF asociado
        Storage::disk('public')->delete($transparencia->pdf);

        $transparencia->delete();

        return response()->json(['message' => 'Transparencia eliminada correctamente.']);
    }
}
