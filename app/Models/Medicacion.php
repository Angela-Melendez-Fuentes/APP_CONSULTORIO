<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'cita_id',
        'nombre',
        'cantidad',
        'frecuencia',
        'fecha_inicio',
        'fecha_fin',
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
