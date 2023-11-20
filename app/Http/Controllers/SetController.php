<?php

namespace App\Http\Controllers;

use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetController extends Controller
{
    public function index()
    {
        try {
            $sets = Set::all();
            return view('sets.index', compact('sets'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }

    public function create()
    {
        return view('sets.create',);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $set = new Set();
            $set->nombre = $request->nombre;
            $set->descripcion = $request->descripcion;
            $set->estado = 1;
            $set->save();

            return response()->json(['messaje' => 'Acción exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error: ' . $th], 500);
        }
    }

    public function edit($id)
    {
        try {
            $set =  Set::find($id);
            return view('sets.edit', compact('set'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error', $th], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $set = Set::find($id);
            $set->nombre = $request->nombre;
            $set->descripcion = $request->descripcion;
            $set->estado = $request->estado;
            $set->save();
            return response()->json(['message' => 'Actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }

}
