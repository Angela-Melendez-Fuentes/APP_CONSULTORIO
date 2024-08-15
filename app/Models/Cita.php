<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'paciente_id', 
        'doctor_id',
        'enfermero_id',  
        'fecha',
        'hora',
        'motivo',
        'observaciones',
        'monto',
        'pagada',
        'talla',
        'temperatura',
        'saturacion_oxigeno',
        'frecuencia_cardiaca',
        'peso',
        'tension_arterial',
        'receta',
        'alergias',
        'diagnostico',
        'estado',
    ];
    
    // Relación con el paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
    public function medicaciones()
    {
        return $this->hasMany(Medicacion::class);
    }


    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }


}
