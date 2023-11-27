<?php

namespace App\Http\Controllers;

use App\Models\TipoAccesorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoAccesorioController extends Controller
{
    public function index()
    {
        try {
            $tipoaccesorios = TipoAccesorio::all();
            return view('tipoaccesorios.index', compact('tipoaccesorios'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error'], 500);
        }
    }

    public function create()
    {
        return view('tipoaccesorios.create',);
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
            $tipoaccesorio = new TipoAccesorio();
            $tipoaccesorio->nombre = $request->nombre;
            $tipoaccesorio->estado = 1;
            $tipoaccesorio->save();

            return response()->json(['messaje' => 'Acción exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error: ' . $th], 500);
        }
    }

    public function edit($id)
    {
        try {
            $tipoAccesorio =  TipoAccesorio::find($id);
            return view('tipoaccesorios.edit', compact('tipoAccesorio'));
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

            $tipoAccesorio = TipoAccesorio::find($id);
            $tipoAccesorio->nombre = $request->nombre;
            $tipoAccesorio->estado = $request->estado;
            $tipoAccesorio->save();
            return response()->json(['message' => 'Actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }
}
