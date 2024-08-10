<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    public function up()
    {
<<<<<<< HEAD
        if(!Schema::hasTable('consultas')){
            Schema::create('consultas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cita_id');
                $table->foreign('cita_id')->references('id')->on('citas')->onDelete('cascade');
                $table->text('alergias')->nullable();
                $table->text('receta')->nullable();
                $table->foreignId('medicamento_id')->nullable()->constrained('medicamentos');
                $table->integer('cantidad')->nullable();
                $table->string('frecuencia')->nullable();
                $table->timestamps();
            });
        }
=======
	if(!Schema::hasTable('consultas')){
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cita_id');
	    $table->foreign('cita_id')->references('id')->on('citas')->onDelete('cascade');
            $table->text('alergias')->nullable();
            $table->text('receta')->nullable();
            $table->foreignId('medicamento_id')->nullable()->constrained('medicamentos');
            $table->integer('cantidad')->nullable();
            $table->string('frecuencia', 255)->nullable();
            $table->timestamps();
        });
	}
>>>>>>> b358250 (ActualizacionBase)
    }

    public function down()
    {
<<<<<<< HEAD
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('consultas');
        Schema::enableForeignKeyConstraints();
=======
	Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('consultas');
	Schema::enableForeignKeyConstraints();
>>>>>>> b358250 (ActualizacionBase)
    }
}
