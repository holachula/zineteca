<?php

namespace App\Http\Controllers;

use App\Models\Tematica;
use Illuminate\Http\Request;

class TematicaController extends Controller
{
    public function index()
    {
        return Tematica::orderBy('nombre')->get();
    }

    public function show($id)
    {
        return Tematica::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        return Tematica::create($validated);
    }

    public function update(Request $request, $id)
    {
        $tematica = Tematica::findOrFail($id);

        $tematica->update($request->only(['nombre']));

        return $tematica;
    }

    public function destroy($id)
    {
        Tematica::findOrFail($id)->delete();
        return response()->json(['message' => 'Temática eliminada']);
    }
}
