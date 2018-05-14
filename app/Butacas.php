<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Butacas extends Model
{
    protected $fillable = [
        'fila_columna', 'estado','idreserva',
    ];
}
