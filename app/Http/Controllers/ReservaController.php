<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\EquipoReserva;
use App\Models\Extra;
use App\Models\ExtraReserva;
use App\Models\Reserva;
use App\Models\Set;
use App\Models\SetReserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservaController extends Controller
{

    public function calendario()
    {
        try {
            $reservas = Reserva::all();
            return view('reserva.calendario', compact('reservas'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error' . $th], 500);
        }
    }
    public function create()
    {
        $equipos = Equipo::where('estado', 1)->get();
        $sets = Set::where('estado', 1)->get();
        $extras = Extra::where('estado', 1)->get();

        return view('reserva.create', compact('equipos', 'sets', 'extras'));
    }
    public function validarReserva(Request $request)
    {
        try {
            $request->validate([
                'fecha' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_final' => 'required|date_format:H:i|after:hora_inicio',
            ]);

            $conflicto = Reserva::where('fecha', $request->fecha)
                ->where('hora_inicio', '<=', $request->hora_inicio)
                ->where('hora_final', '>', $request->hora_inicio)
                ->exists();

            if ($conflicto) {
                return response()->json(['message' => 'Ya hay una reserva para esa fecha y horario.'], 404);
            }

            $equipos = Equipo::where('estado', 1)->get();
            $sets = Set::where('estado', 1)->get();
            $extras = Extra::where('estado', 1)->get();

            return response()->json([
                'message' => 'Reserva disponible.',
                'equipos' => $equipos->toArray(),
                'sets' => $sets->toArray(),
                'extras' => $extras->toArray(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error ' . $e], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validación
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255',
                'fecha' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_final' => 'required|date_format:H:i|after:hora_inicio',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Comprobación de conflicto
            $conflicto = Reserva::where('fecha', $request->fecha)
                ->where('hora_inicio', '<=', $request->hora_inicio)
                ->where('hora_final', '>', $request->hora_inicio)
                ->exists();

            if ($conflicto) {
                return response()->json(['message' => 'Ya hay una reserva para esa fecha y horario.'], 404);
            }

            // Crear la reserva
            $reserva = new Reserva();
            $reserva->nombre = $request->nombre;
            $reserva->descripcion = $request->descripcion;
            $reserva->fecha = $request->fecha;
            $reserva->hora_inicio = $request->hora_inicio;
            $reserva->hora_final = $request->hora_final;
            $reserva->idUsuario = Auth::id();
            $reserva->save();

            // Asociar equipos
            foreach ($request->equipos as $equipoId) {
                $equipoReserva = new EquipoReserva();
                $equipoReserva->idEquipo = $equipoId;
                $equipoReserva->idReserva = $reserva->id;
                $equipoReserva->save();
            }

            // Asociar sets
            foreach ($request->sets as $setId) {
                $setReserva = new SetReserva();
                $setReserva->idSet = $setId;
                $setReserva->idReserva = $reserva->id;
                $setReserva->save();
            }

            // Asociar extras
            foreach ($request->extras as $extraId) {
                $extraReserva = new ExtraReserva();
                $extraReserva->idExtra = $extraId;
                $extraReserva->idReserva = $reserva->id;
                $extraReserva->save();
            }

            return response()->json(['message' => 'Reserva creada con éxito.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error: ' . $th], 500);
        }
    }
}
