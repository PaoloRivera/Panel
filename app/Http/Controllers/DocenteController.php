<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocenteController extends Controller
{
    public function index()
    {
        return Docente::all();
    }

    public function show($id)
    {
        $docente = Docente::find($id);

        if (!$docente) {
            return response()->json(['error' => 'Docente no encontrado.'], 404);
        }

        return $docente;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'redes_sociales' => 'nullable|string|max:255',
            'redes_sociales_dos' => 'nullable|string|max:255',
            'redes_sociales_tres' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('docentes', 'public') : null;

        $docente = Docente::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'cargo' => $request->cargo,
            'redes_sociales' => $request->redes_sociales,
            'redes_sociales_dos' => $request->redes_sociales_dos,
            'redes_sociales_tres' => $request->redes_sociales_tres,
            'foto' => $fotoPath,
        ]);

        return response()->json($docente, 201);
    }

    public function update(Request $request, $id)
    {
        $docente = Docente::find($id);

        if (!$docente) {
            return response()->json(['error' => 'Docente no encontrado.'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'redes_sociales' => 'nullable|string|max:255',
            'redes_sociales_dos' => 'nullable|string|max:255',
            'redes_sociales_tres' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($docente->foto);
            $docente->foto = $request->file('foto')->store('docentes', 'public');
        }

        $docente->update($request->only('nombre', 'descripcion', 'cargo', 'redes_sociales', 'redes_sociales_dos', 'redes_sociales_tres'));

        return response()->json($docente);
    }

    public function destroy($id)
    {
        $docente = Docente::find($id);

        if (!$docente) {
            return response()->json(['error' => 'Docente no encontrado.'], 404);
        }

        Storage::disk('public')->delete($docente->foto);
        $docente->delete();

        return response()->json(['message' => 'Docente eliminado correctamente.']);
    }
}
