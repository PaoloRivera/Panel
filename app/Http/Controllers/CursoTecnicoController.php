<?php

namespace App\Http\Controllers; // Cambiado de API a Controllers

use App\Models\CursoTecnico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CursoTecnicoController extends Controller
{
    public function index()
    {
        try {
            $cursos = CursoTecnico::all();
            return response()->json($cursos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_docente' => 'nullable|integer',
            'modalidad' => 'required|in:presencial,virtual,hibrido',
            'estado' => 'nullable|in:activado,desactivado'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $data = $request->all();
            
            if ($request->hasFile('imagen')) {
                $path = $request->file('imagen')->store('cursos', 'public');
                $data['imagen'] = $path;
            }

            $curso = CursoTecnico::create($data);
            return response()->json($curso, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $curso = CursoTecnico::findOrFail($id);
            return response()->json($curso);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Curso no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'modalidad' => 'sometimes|in:presencial,virtual,hibrido',
            'estado' => 'nullable|in:activado,desactivado'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $curso = CursoTecnico::findOrFail($id);
            $data = $request->all();

            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($curso->imagen) {
                    Storage::disk('public')->delete($curso->imagen);
                }
                $path = $request->file('imagen')->store('cursos', 'public');
                $data['imagen'] = $path;
            }

            $curso->update($data);
            return response()->json($curso);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $curso = CursoTecnico::findOrFail($id);
            
            if ($curso->imagen) {
                Storage::disk('public')->delete($curso->imagen);
            }
            
            $curso->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}