<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_reservas', 'idReserva', 'idEquipo');
    }
    public function sets()
    {
        return $this->belongsToMany(Set::class, 'set_reservas', 'idReserva', 'idSet');
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'extra_reservas', 'idReserva', 'idExtra');
    }

    public function asistentes()
    {
        return $this->belongsToMany(Asistente::class, 'asistente_reservas', 'idReserva', 'idAsistente');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'user_reservas', 'idReserva', 'idUser');
    }
    public function accesorios()
    {
        return $this->belongsToMany(Accesorio::class, 'accesorio_reservas', 'idReserva', 'idAccesorio');
    }
}
