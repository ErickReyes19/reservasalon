<?php

namespace App\Http\Controllers;

use App\Models\Accesorio;
use App\Models\Equipo;
use App\Models\TipoAccesorio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccesorioController extends Controller
{
    public function index()
    {
        try {
            $accesorios = Accesorio::all();

            foreach ($accesorios as $accesorio) {
                $accesorio['tipo_accesorios'] = TipoAccesorio::find($accesorio->tipo_accesorios_id);
                $accesorio['users'] = User::find($accesorio->idUsuario);
    
            }
            return view('accesorios.index', compact('accesorios'));
            // return response()->json(['reserva' => $accesorios], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error' . $th->getMessage()], 500);
        }
    }

    public function create()
    {
        $tipoAccesorios = TipoAccesorio::where('estado', 1)->get();
        return view('accesorios.create', compact('tipoAccesorios'));
    }

    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255',
                'tipo_accesorios_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $accesorio = new Accesorio();
            $accesorio->nombre = $request->nombre;
            $accesorio->descripcion = $request->descripcion;
            $accesorio->tipo_accesorios_id = $request->tipo_accesorios_id;
            $accesorio->idUsuario = Auth::id();
            $accesorio->estado = 1;
            $accesorio->save();

            return response()->json(['messaje' => 'Acción exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error: ' . $th], 500);
        }
    }


    public function edit($id)
    {
        try {
            $accesorio = Accesorio::find($id);
    
            if (auth()->check() && $accesorio->idUsuario != auth()->user()->id) {
                return redirect()->route('accesorio.index')->with('error', 'No tienes permisos para editar este accesorio.');
            }
    
            $tipoAccesorios = TipoAccesorio::where('estado', 1)->get();
            return view('accesorios.edit', compact('accesorio', 'tipoAccesorios'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error', $th], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255',
                'tipo_accesorios_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $accesorio = Accesorio::find($id);
            $accesorio->nombre = $request->nombre;
            $accesorio->descripcion = $request->descripcion;
            $accesorio->tipo_accesorios_id = $request->tipo_accesorios_id;
            $accesorio->idUsuario = Auth::id();
            $accesorio->estado = $request->estado;
            $accesorio->save();
            return response()->json(['message' => 'Actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }
}
