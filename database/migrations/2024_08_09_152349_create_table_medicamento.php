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
<<<<<<< HEAD
        if(Schema::hasTable('medicamentos')){
            Schema::create('medicamentos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('descripcion');
                $table->float('precio');
                $table->integer('cantidad');
                $table->timestamps();
            });
        }
=======
        Schema::create('table_medicamento', function (Blueprint $table) {
            $table->id();
            $table->string ('nombre');
            $table->string ('descripcion');
            $table->float('precio');
            $table->integer('cantidad');
            $table->timestamps();
        });
>>>>>>> b358250 (ActualizacionBase)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('medicamentos');
        Schema::enableForeignKeyConstraints();
    }
};
