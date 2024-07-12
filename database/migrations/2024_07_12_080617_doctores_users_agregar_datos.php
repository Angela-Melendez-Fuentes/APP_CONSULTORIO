<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class doctoresUsersAgregarDatos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono')->nullable();
            $table->string('rfc')->nullable();
            $table->string('cedula_profesional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telefono');
            $table->dropColumn('rfc');
            $table->dropColumn('cedula_profesional');
        });
    }
}
