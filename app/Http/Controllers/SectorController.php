<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {
        return response()->json(Sector::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|unique:sectores,nombre',
        ]);

        return response()->json(Sector::create($data), 201);
    }

    public function show(Sector $sector)
    {
        return response()->json($sector);
    }

    public function update(Request $request, Sector $sector)
    {
        $data = $request->validate([
            'nombre' => 'required|string|unique:sectores,nombre,'.$sector->id,
        ]);

        $sector->update($data);
        return response()->json($sector);
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();
        return response()->json(null, 204);
    }
}
