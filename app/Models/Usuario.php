<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Usuario extends Model
{   
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';  
    public $incrementing = true;  
    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'email',
        'telefono' ,
        'password'
     
    ]; 

    protected $hidden = [
        'password'
    ];
    
}
