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
        Schema::create('experiencia_profesional_docentes', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal_d')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cargos_desempenados')->nullable();
            $table->string('empresa_institucion')->nullable();
            $table->date('fecha_inicio_empresa')->nullable();
            $table->date('fecha_fin_empresa')->nullable();
            $table->string('cargo_desempenado_empresa')->nullable();
            $table->string('descripcion_funciones_empresa')->nullable();
            $table->string('logros_resultados_empresa')->nullable();
            $table->string('practicas_profesionales')->nullable();
            $table->string('empresa_institucion_practicas')->nullable();
            $table->date('fecha_inicio_practicas')->nullable();
            $table->date('fecha_fin_practicas')->nullable();
            $table->string('area_trabajo_practicas')->nullable();
            $table->string('descripcion_funciones_practicas')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiencia_profesional_docentes');
    }
};
