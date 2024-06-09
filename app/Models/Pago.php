<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'tratamiento_id',
        'cita_id',
        'tipo_pago',
        'monto',
        'fecha_pago',
        'metodo_pago',
        'usuario_id',
        'estado',
    ];
}
