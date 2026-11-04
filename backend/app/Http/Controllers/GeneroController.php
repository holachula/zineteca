<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function index()
    {
        return Genero::orderBy('nombre')->get();
    }

    public function show($id)
    {
        return Genero::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        return Genero::create($validated);
    }

    public function update(Request $request, $id)
    {
        $genero = Genero::findOrFail($id);

        $genero->update($request->only(['nombre']));

        return $genero;
    }

    public function destroy($id)
    {
        Genero::findOrFail($id)->delete();
        return response()->json(['message' => 'Género eliminado']);
    }
}
