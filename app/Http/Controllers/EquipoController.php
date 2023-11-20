<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TipoEquipo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EquipoController extends Controller
{
    public function index()
    {
        try {
            $equipos = Equipo::all();

            foreach ($equipos as $equipo) {
                $equipo['tipo_equipos'] = TipoEquipo::find($equipo->tipo_equipo_id);
                $equipo['users'] = User::find($equipo->idUsuario);
    
            }
            return view('equipos.index', compact('equipos'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error' . $th], 500);
        }
    }

    public function create()
    {
        $tipoEquipos = TipoEquipo::where('estado', 1)->get();
        return view('equipos.create', compact('tipoEquipos'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255',
                'tipo_equipo_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $equipo = new Equipo();
            $equipo->nombre = $request->nombre;
            $equipo->descripcion = $request->descripcion;
            $equipo->tipo_equipo_id = $request->tipo_equipo_id;
            $equipo->idUsuario = Auth::id();
            $equipo->estado = 1;
            $equipo->disponible = 1;
            $equipo->save();

            return response()->json(['messaje' => 'Acción exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error: ' . $th], 500);
        }
    }

    public function edit($id)
    {
        try {
            $equipo = Equipo::find($id);
    
            if (auth()->check() && $equipo->idUsuario != auth()->user()->id) {
                return redirect()->route('equipo.index')->with('error', 'No tienes permisos para editar este equipo.');
            }
    
            $tipoEquipos = TipoEquipo::where('estado', 1)->get();
            return view('equipos.edit', compact('equipo', 'tipoEquipos'));
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
                'tipo_equipo_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $equipo = Equipo::find($id);
            $equipo->nombre = $request->nombre;
            $equipo->descripcion = $request->descripcion;
            $equipo->tipo_equipo_id = $request->tipo_equipo_id;
            $equipo->idUsuario = Auth::id();
            $equipo->estado = $request->estado;
            $equipo->disponible = $request->disponible;
            $equipo->save();
            return response()->json(['message' => 'Actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error ' . $th], 500);
        }
    }
}
