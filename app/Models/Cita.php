<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas'; 

    protected $fillable = [
        'nombre',
        'doctor_id',
        'fecha',
        'hora',
        'motivo',
        'observaciones',
        'pagada',
    ];
    
    // Relación con el paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
