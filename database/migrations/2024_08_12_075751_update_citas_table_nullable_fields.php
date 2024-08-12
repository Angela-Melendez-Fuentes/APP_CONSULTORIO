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
        Schema::table('citas', function (Blueprint $table) {
            $table->string('observaciones')->nullable()->change();
            $table->string('pagada')->nullable()->change();
            $table->string('talla')->nullable()->change();
            $table->decimal('temperatura')->nullable()->change();
            $table->decimal('saturacion_oxigeno')->nullable()->change();
            $table->string('frecuencia_cardiaca')->nullable()->change();
            $table->decimal('peso')->nullable()->change();
            $table->string('tension_arterial')->nullable()->change();
            $table->string('receta')->nullable()->change();
            $table->string('diagnostico')->nullable()->change();
            $table->string('alergias')->nullable()->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->string('observaciones')->nullable(false)->change();
            $table->string('pagada')->nullable(false)->change();
            $table->string('talla')->nullable(false)->change();
            $table->decimal('temperatura')->nullable(false)->change();
            $table->decimal('saturacion_oxigeno')->nullable(false)->change();
            $table->string('frecuencia_cardiaca')->nullable(false)->change();
            $table->decimal('peso')->nullable(false)->change();
            $table->string('tension_arterial')->nullable(false)->change();
            $table->string('receta')->nullable(false)->change();
            $table->string('diagnostico')->nullable(false)->change();
            $table->string('alergias')->nullable(false)->change();
        });
    }
    
};
