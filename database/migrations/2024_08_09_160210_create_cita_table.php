<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
	if(!Schema::hasTable('citas')){
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('fecha');
            $table->time('hora');
            $table->string('motivo');
            $table->string('observaciones');
            $table->decimal('monto');
            $table->string('pagada')->nullable();
            $table->string('talla')->nullable();
            $table->decimal('temperatura')->nullable();
            $table->decimal('saturacion_oxigeno')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->decimal('peso')->nullable();
            $table->string('tension_arterial')->nullable();
            $table->string('receta')->nullable();
            $table->string('diagnostico')->nullable();
            $table->string('alergias')->nullable();

            $table->timestamps();
        });
	}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
	Schema::disableForeignKeyConstraints();	
        Schema::dropIfExists('citas');
	Schema::enableForeignKeyConstraints();
    }
};
