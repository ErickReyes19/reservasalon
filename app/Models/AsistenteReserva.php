<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenteReserva extends Model
{
    use HasFactory;

    public function asistente()
    {
        return $this->belongsTo(Asistente::class, 'idAsistente');
    }
}
