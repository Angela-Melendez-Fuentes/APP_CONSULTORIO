<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyForPacienteIdInCitasTable extends Migration
{
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            // Primero elimina la clave foránea incorrecta si existe
            $table->dropForeign(['paciente_id']);
            
            // Luego agrega la clave foránea correcta
            $table->foreign('paciente_id')
                ->references('id')
                ->on('pacientes')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            // Elimina la clave foránea correcta si es necesario revertir los cambios
            $table->dropForeign(['paciente_id']);
            
            // Restaurar la clave foránea incorrecta si es necesario
            $table->foreign('paciente_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }
}
