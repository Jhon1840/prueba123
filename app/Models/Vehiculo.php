<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculo';
    protected $primaryKey = 'id_vehiculo';

    // Indicar que el modelo no debe autoincrementar si tu ID no es autoincrementable
    //public $incrementing = false;

    // Especificar qué campos pueden ser asignados masivamente.
    protected $fillable = [
        'marca',
        'matricula',
        'color',
        'altura',
        'ancho',
        'largo',
        'modelo',
        'id_usuario'  
    ];

    // Indicar la relación con el modelo Usuario, si existe
    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'id_usuario');
    }
}
