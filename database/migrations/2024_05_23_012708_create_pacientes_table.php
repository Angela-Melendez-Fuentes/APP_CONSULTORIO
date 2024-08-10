<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('pacientes')){
            Schema::create('pacientes', function (Blueprint $table) {
                $table->id(); // This creates an auto_increment primary key column named `id`
                $table->string('nombre', 255);
                $table->string('apellido_p', 255);
                $table->string('apellido_m', 255);
                $table->string('age', 255);
                $table->string('correo', 255);
                $table->string('telefono', 255);
                $table->date('fecha_nacimiento');
                $table->enum('genero_biologico', ['Masculino', 'Femenino']);
                $table->timestamps(); // This creates `created_at` and `updated_at` columns
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pacientes');
        Schema::enableForeignKeyConstraints();
     }
}
