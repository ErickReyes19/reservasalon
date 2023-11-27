<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetReserva extends Model
{
    use HasFactory;

    public function set()
    {
        return $this->belongsTo(Set::class, 'idSet');
    }
}
