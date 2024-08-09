<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignosVitalesToCitasTable extends Migration
{
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->float('talla')->nullable();
            $table->float('temperatura')->nullable();
            $table->float('saturacion_oxigeno')->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->float('peso')->nullable();
            $table->string('tension_arterial')->nullable();
            
        });
    }

    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn(['talla', 'temperatura', 'saturacion_oxigeno', 'frecuencia_cardiaca', 'peso', 'tension_arterial']);
        });
    }
}
