<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->unsignedBigInteger('enfermero_id')->nullable()->after('doctor_id');
            $table->foreign('enfermero_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['enfermero_id']);
            $table->dropColumn('enfermero_id');
        });
    }

    
};
