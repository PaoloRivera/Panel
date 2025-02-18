<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Retorna todos los sliders.
     */
    public function index()
    {
        return Slider::all();
    }

    /**
     * Retorna un slider específico por su ID.
     */
    public function show($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json(['error' => 'Slider no encontrado.'], 404);
        }

        return $slider;
    }

    /**
     * Crear un nuevo slider.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'boton' => 'nullable|string|max:100',
        ]);

        // Guardar la imagen en el disco público
        $logoPath = $request->file('logo')->store('sliders', 'public');

        // Crear el slider con la ruta de la imagen
        $slider = Slider::create([
            'logo' => $logoPath,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'boton' => $request->boton,
        ]);

        return response()->json($slider, 201);
    }

    /**
     * Actualizar un slider existente.
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json(['error' => 'Slider no encontrado.'], 404);
        }

        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'boton' => 'nullable|string|max:100',
        ]);

        // Verificar si se subió un archivo nuevo
        if ($request->hasFile('logo')) {
            // Eliminar la imagen anterior
            Storage::disk('public')->delete($slider->logo);

            // Guardar la nueva imagen
            $logoPath = $request->file('logo')->store('sliders', 'public');
            $slider->logo = $logoPath;
        }

        // Actualizar los demás campos
        $slider->titulo = $request->titulo;
        $slider->descripcion = $request->descripcion;
        $slider->boton = $request->boton;
        $slider->save();

        return response()->json($slider);
    }

    /**
     * Eliminar un slider.
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json(['error' => 'Slider no encontrado.'], 404);
        }

        // Eliminar la imagen asociada
        Storage::disk('public')->delete($slider->logo);

        $slider->delete();

        return response()->json(['message' => 'Slider eliminado correctamente.']);
    }
}
