<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExtraController extends Controller
{
    public function index()
    {
        try {
            $extras = Extra::all();
            return view('extras.index', compact('extras'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }

    public function create()
    {
        return view('extras.create',);
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
            $extra = new Extra();
            $extra->nombre = $request->nombre;
            $extra->descripcion = $request->descripcion;
            $extra->estado = 1;
            $extra->disponible = 1;
            $extra->save();

            return response()->json(['messaje' => 'Acción exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error: ' . $th], 500);
        }
    }

    public function edit($id)
    {
        try {
            $extra =  Extra::find($id);
            return view('extras.edit', compact('extra'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error', $th], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $extra = Extra::find($id);
            $extra->nombre = $request->nombre;
            $extra->descripcion = $request->descripcion;
            $extra->estado = $request->estado;
            $extra->disponible = $request->disponible;
            $extra->save();
            return response()->json(['message' => 'Actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }
}
