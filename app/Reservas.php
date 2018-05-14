<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
      protected $fillable = [
        'fecha', 'nropersonas','idusuarios',
    ];
}
