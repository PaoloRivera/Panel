<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    // Obtener todas las empresas
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    // Obtener una empresa específica
    public function show($ruc)
    {
        $empresa = Empresa::find($ruc);

        if ($empresa) {
            return response()->json($empresa);
        }

        return response()->json(['message' => 'Empresa no encontrada'], 404);
    }

    // Crear una nueva empresa
    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'ruc' => 'required|string|size:11|unique:empresas,ruc',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:5120', // 5MB = 5120KB
            'estado' => 'required|in:activado,desactivado',
        ]);

        // Manejar el logo si se proporciona
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public'); // Guarda la imagen en la carpeta 'logos'
        }

        // Crear la nueva empresa
        $empresa = Empresa::create([
            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'direccion' => $request->direccion,
            'logo' => $logoPath, // Guardamos la ruta del archivo
            'estado' => $request->estado,
        ]);

        return response()->json($empresa, 201);  // Devolvemos la empresa creada
    }

    // Actualizar los datos de una empresa
    public function update(Request $request, $ruc)
    {
        $empresa = Empresa::find($ruc);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        // Validación de los campos
        $request->validate([
            'razon_social' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:255',  // Validación para el archivo de logo
            'estado' => 'required|in:activado,desactivado',
        ]);

        // Manejar el logo si se proporciona
        if ($request->hasFile('logo')) {
            // Si ya existe un logo anterior, lo eliminamos
            if ($empresa->logo && Storage::exists('public/' . $empresa->logo)) {
                Storage::delete('public/' . $empresa->logo);
            }

            // Guardamos el nuevo logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            $empresa->logo = $logoPath;
        }

        // Actualizar la empresa con los datos proporcionados
        $empresa->update([
            'razon_social' => $request->razon_social,
            'direccion' => $request->direccion,
            'logo' => isset($logoPath) ? $logoPath : $empresa->logo, // Si no se sube un nuevo logo, mantenemos el anterior
            'estado' => $request->estado,
        ]);

        return response()->json($empresa);
    }

    // Eliminar una empresa
    public function destroy($ruc)
    {
        $empresa = Empresa::find($ruc);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        // Eliminar el logo si existe
        if ($empresa->logo && Storage::exists('public/' . $empresa->logo)) {
            Storage::delete('public/' . $empresa->logo);
        }

        // Eliminar la empresa
        $empresa->delete();
        return response()->json(['message' => 'Empresa eliminada']);
    }
}
