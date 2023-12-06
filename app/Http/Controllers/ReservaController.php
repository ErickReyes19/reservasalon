<?php

namespace App\Http\Controllers;

use App\Models\Accesorio;
use App\Models\Asistente;
use App\Models\AsistenteReserva;
use App\Models\Equipo;
use App\Models\EquipoReserva;
use App\Models\Extra;
use App\Models\ExtraReserva;
use App\Models\Reserva;
use App\Models\Set;
use App\Models\SetReserva;
use App\Models\TipoReserva;
use App\Models\User;
use App\Models\UserReserva;
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
    public function index()
    {
        try {
            $reservas = Reserva::where('idUsuario', Auth::id())->get();
            return view('reserva.index', compact('reservas'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error' . $th], 500);
        }
    }

    public function create()
    {
        $equipos = Equipo::where('estado', 1)->get();
        $sets = Set::where('estado', 1)->get();
        $extras = Extra::where('estado', 1)->get();
        $tipoReservas = TipoReserva::all();

        return view('reserva.create', compact('equipos', 'sets', 'extras', 'tipoReservas'));
    }
    public function validarReserva(Request $request)
    {
        try {
            $request->validate([
                'fecha' => 'required|date|after_or_equal:today',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_final' => 'required|date_format:H:i|after:hora_inicio',
            ]);

            $tipoReserva = $request->tipoReserva;
            // Obtener equipos, extras y accesorios disponibles para todas las reservas (tanto internas como externas)
            $equiposDisponibles = Equipo::where('estado', 1)
                ->whereNotIn('id', function ($query) use ($request) {
                    $query->select('idEquipo')
                        ->from('equipo_reservas')
                        ->join('reservas', 'equipo_reservas.idReserva', '=', 'reservas.id')
                        ->where('reservas.fecha', $request->fecha)
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('reservas.hora_inicio', [$request->hora_inicio, $request->hora_final])
                                ->orWhereBetween('reservas.hora_final', [$request->hora_inicio, $request->hora_final]);
                        });
                })
                ->get();


            $extrasDisponibles = Extra::where('estado', 1)
                ->whereNotIn('id', function ($query) use ($request) {
                    $query->select('idExtra')
                        ->from('extra_reservas')
                        ->join('reservas', 'extra_reservas.idReserva', '=', 'reservas.id')
                        ->where('reservas.fecha', $request->fecha)
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('reservas.hora_inicio', [$request->hora_inicio, $request->hora_final])
                                ->orWhereBetween('reservas.hora_final', [$request->hora_inicio, $request->hora_final]);
                        });
                })
                ->get();


            $accesoriosDisponibles = Accesorio::where('estado', 1)
                ->whereNotIn('id', function ($query) use ($request) {
                    $query->select('idAccesorio')
                        ->from('accesorio_reservas')
                        ->join('reservas', 'accesorio_reservas.idReserva', '=', 'reservas.id')
                        ->where('reservas.fecha', $request->fecha)
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('reservas.hora_inicio', [$request->hora_inicio, $request->hora_final])
                                ->orWhereBetween('reservas.hora_final', [$request->hora_inicio, $request->hora_final]);
                        });
                })
                ->get();



            if ($tipoReserva == 1) {
                // Validación de conflicto para reservas internas
                $conflicto = Reserva::where('fecha', $request->fecha)
                    ->where('hora_inicio', '<=', $request->hora_inicio)
                    ->where('hora_final', '>', $request->hora_inicio)
                    ->exists();

                if ($conflicto) {
                    return response()->json(['message' => 'Ya hay una reserva para esa fecha y horario.'], 404);
                }
            }

            // Obtener el resto de la información necesaria para la reserva
            $usuarios = User::where('id', '!=', Auth::id())->get();
            $sets = Set::where('estado', 1)->get();
            $asistentes = Asistente::where('estado', 1)
                ->where('idUsuario', Auth::id())
                ->get();

            // Retornar la respuesta con la información recopilada
            return response()->json([
                'message' => 'Reserva disponible.',
                'equipos' => $equiposDisponibles->toArray(),
                'extras' => $extrasDisponibles->toArray(),
                'accesorios' => $accesoriosDisponibles->toArray(),
                'usuarios' => $usuarios->toArray(),
                'sets' => $sets->toArray(),
                'asistentes' => $asistentes->toArray(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error ' . $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        try {

            $tipoReserva = $request->tipoReserva;

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

            if ($tipoReserva == 1) {
                // Validación de conflicto para reservas internas
                $conflicto = Reserva::where('fecha', $request->fecha)
                    ->where('hora_inicio', '<=', $request->hora_inicio)
                    ->where('hora_final', '>', $request->hora_inicio)
                    ->exists();

                if ($conflicto) {
                    return response()->json(['message' => 'Ya hay una reserva para esa fecha y horario.'], 404);
                }
            }

            // Crear la reserva
            $reserva = new Reserva();
            $reserva->nombre = $request->nombre;
            $reserva->descripcion = $request->descripcion;
            $reserva->fecha = $request->fecha;
            $reserva->hora_inicio = $request->hora_inicio;
            $reserva->hora_final = $request->hora_final;
            $reserva->idTipoReserva = $request->tipoReserva;
            switch (Auth::id()) {
                case 1:
                    $reserva->color = 'red';
                    break;
                case 2:
                    $reserva->color = 'blue';
                    break;
                case 3:
                    $reserva->color = 'green';
                    break;
                default:
                    $reserva->color = 'yellow';
                    break;
            }
            $reserva->idUsuario = Auth::id();
            $reserva->save();

            // Asociar equipos
            if (!empty($request->equipos)) {
                foreach ($request->equipos as $equipoId) {
                    $equipoReserva = new EquipoReserva();
                    $equipoReserva->idEquipo = $equipoId;
                    $equipoReserva->idReserva = $reserva->id;
                    $equipoReserva->save();
                }
            }

            // Asociar sets
            if (!empty($request->sets)) {
                foreach ($request->sets as $setId) {
                    $setReserva = new SetReserva();
                    $setReserva->idSet = $setId;
                    $setReserva->idReserva = $reserva->id;
                    $setReserva->save();
                }
            }

            // Asociar extras
            if (!empty($request->extras)) {
                foreach ($request->extras as $extraId) {
                    $extraReserva = new ExtraReserva();
                    $extraReserva->idExtra = $extraId;
                    $extraReserva->idReserva = $reserva->id;
                    $extraReserva->save();
                }
            }

            // Asociar asistentes
            if (!empty($request->asistentes)) {
                foreach ($request->asistentes as $asistenteId) {
                    $asistenteReserva = new AsistenteReserva();
                    $asistenteReserva->idAsistente = $asistenteId;
                    $asistenteReserva->idReserva = $reserva->id;
                    $asistenteReserva->save();
                }
            }

            // Asociar usuarios
            if (!empty($request->usuarios)) {
                foreach ($request->usuarios as $usuarioId) {
                    $userReserva = new UserReserva();
                    $userReserva->idUser = $usuarioId;
                    $userReserva->idReserva = $reserva->id;
                    $userReserva->save();
                }
            }


            return response()->json(['message' => 'Reserva creada con éxito.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error: ' . $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $reserva = Reserva::with([
                'equipos',
                'sets',
                'extras',
                'asistentes',
                'usuarios',
            ])->find($id);
            $reserva['users'] = User::find($reserva->idUsuario);

            foreach ($reserva->equipos as $equipo) {
                $nombreUsuario = $equipo->usuario->name;
            }

            $mensaje = "No hay Reserva";

            if (!$reserva) {
                return view('reserva.show', compact('mensaje'));
            }


            return view('reserva.show', compact('reserva'));
            // return response()->json(['reserva' => $reserva], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error: ' . $th->getMessage()], 500);
        }
    }
}
