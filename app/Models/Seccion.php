<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = 'seccion';
    protected $primaryKey = 'id_seccion';
    protected $fillable = [
        'imagen_seccion', 'ancho', 'largo', 'hora_inicio',
        'hora_final', 'estado', 'altura', 'id_garaje'
    ];
}