<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Paciente extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre', 
        'apellido_p', 
        'apellido_m', 
        'age', 
        'correo', 
        'telefono', 
        'fecha_nacimiento', 
        'genero_biologico'
    ];

    // Relación con las citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    
}
