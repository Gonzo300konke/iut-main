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
        Schema::table('bienes', function (Blueprint $table) {
            // Campos para electrónicos
            $table->string('serial')->nullable();
            $table->string('procesador')->nullable();
            $table->text('caracteristicas')->nullable();

            // Campos para inmuebles
            $table->string('direccion')->nullable();
            $table->float('area')->nullable();
            $table->string('uso')->nullable();

            // Campos para muebles
            $table->string('material')->nullable();
            $table->string('dimensiones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bienes', function (Blueprint $table) {
            $table->dropColumn(['serial', 'procesador', 'caracteristicas', 'direccion', 'area', 'uso', 'material', 'dimensiones']);
        });
    }
};
