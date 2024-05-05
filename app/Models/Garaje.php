<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garaje extends Model
{
    protected $table = 'garaje';
    protected $primaryKey = 'id_garaje';
    protected $fillable = [
        'imagen_garaje', 'ancho', 'largo', 'direccion',
        'notas', 'referencias', 'latitud', 'longitud', 'id_usuario'
    ];

    public function secciones()
    {
        return $this->hasMany('App\Models\Seccion', 'id_garaje', 'id_garaje');
    }
}