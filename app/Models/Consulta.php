<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cita_id',
        'receta',
        'alergias',
        'medicamento',
        'cantidad',
        'frecuencia',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}
