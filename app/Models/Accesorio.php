<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesorio extends Model
{
    use HasFactory;


    public function accesorio()
    {
        return $this->belongsTo(Accesorio::class, 'idAccesorio');
    }
}
