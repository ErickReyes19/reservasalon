<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraReserva extends Model
{
    use HasFactory;

    public function extra()
    {
        return $this->belongsTo(Extra::class, 'idExtra');
    }
}
