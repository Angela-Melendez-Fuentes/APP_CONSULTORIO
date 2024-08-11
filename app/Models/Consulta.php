<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [
        'talla',
        'temperatura',
        'peso',
        'tension_arterial',
        'saturacion_oxigeno',
        'frecuencia_cardiaca',
        'motivo',
        'alergias',
        'diagnostico',
        'receta',
    ];

    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class)->withPivot('cantidad', 'frecuencia');
    }
}
