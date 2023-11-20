<?php

namespace App\Http\Controllers;

use App\Models\TipoEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoEquipoController extends Controller
{
    public function index()
    {
        try {
            $tipoequipos = TipoEquipo::all();
            return view('tipoequipos.index', compact('tipoequipos'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error'], 500);
        }
    }

    public function create()
    {
        return view('tipoequipos.create',);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $tipoEquipo = new TipoEquipo();
            $tipoEquipo->nombre = $request->nombre;
            $tipoEquipo->estado = 1;
            $tipoEquipo->save();

            return response()->json(['messaje' => 'Acción exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error: ' . $th], 500);
        }
    }

    
    public function edit($id)
    {
        try {
            $tipoEquipo =  TipoEquipo::find($id);
            return view('tipoequipos.edit', compact('tipoEquipo'));
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

            $tipoEquipo = TipoEquipo::find($id);
            $tipoEquipo->nombre = $request->nombre;
            $tipoEquipo->estado = $request->estado;
            $tipoEquipo->save();
            return response()->json(['message' => 'Actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }

    public function desactive($id)
    {
        try {
            $tipoEquipo = TipoEquipo::find($id);
            $tipoEquipo->estado = 0;
            $tipoEquipo->save();
            return response()->json(['message' => 'Eliminado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error.'], 500);
        }
    }
}
