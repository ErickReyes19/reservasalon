<?php

namespace App\Http\Controllers;

use App\Models\Asistente;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AsistenteController extends Controller
{
    public function index()
    {
        try {
            $asistentes = Asistente::where('idUsuario', Auth::id())->get();
            return view('asistentes.index', compact('asistentes'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error' . $th], 500);
        }
    }


    public function create()
    {
        return view('asistentes.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $sistente = new Asistente();
            $sistente->nombre = $request->nombre;
            $sistente->idUsuario = Auth::id();
            $sistente->estado = 1;
            $sistente->save();

            return response()->json(['messaje' => 'Acción exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error: ' . $th-> getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $asistente = Asistente::find($id);
    
            if (auth()->check() && $asistente->idUsuario != auth()->user()->id) {
                return redirect()->route('asistente.index')->with('error', 'No tienes permisos para editar este asistente.');
            }
    
            return view('asistentes.edit', compact('asistente'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error', 'message' => $th->getMessage()], 500);
        }
    }
    

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $asistente = Asistente::find($id);
            $asistente->nombre = $request->nombre;
            $asistente->idUsuario = Auth::id();
            $asistente->estado = $request->estado;
            $asistente->save();
            return response()->json(['message' => 'Actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }
}
