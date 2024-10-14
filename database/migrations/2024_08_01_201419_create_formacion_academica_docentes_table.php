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
        Schema::create('formacion_academica_docentes', function (Blueprint $table) {
            $table->bigIncrements("id");
           
            $table->string('CIInfPer'); 
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal_d')->onDelete('cascade')->onUpdate('cascade');
            $table->string('estudios_bachiller_culminados')->nullable();
            $table->string('titulo_bachiller_obtenido')->nullable();
            $table->string('institucion_bachiller')->nullable();
            $table->date('fecha_graduacion_bachiller')->nullable();
            $table->string('especialidad_bachiller')->nullable();
            $table->string('estudios_universitarios_culminados')->nullable();
            $table->string('titulo_universitario_obtenido')->nullable();
            $table->string('institucion_universitaria')->nullable();
            $table->date('fecha_graduacion')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('estudios_posgrado_culminados')->nullable();
            $table->string('titulo_posgrado_obtenido')->nullable();
            $table->string('institucion_posgrado')->nullable();
            $table->date('fecha_graduacion_posgrado')->nullable();
            $table->string('especialidad_posgrado')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formacion_academica_docentes');
    }
};
