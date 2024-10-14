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
        Schema::create('curso_capacitaciones', function (Blueprint $table) {
            $table->bigIncrements("id");
            /*$table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');*/
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal')->onDelete('cascade')->onUpdate('cascade');
            $table->string('intitucion_curso')->nullable();
            $table->string('tipo_evento')->nullable();
            $table->string('area_estudios')->nullable();
            $table->string('nombre_evento')->nullable();
            $table->string('facilitador_curso')->nullable();
            $table->string('tipo_certificado')->nullable();
            $table->date('fecha_inicio_curso')->nullable();
            $table->date('fecha_fin_curso')->nullable();
            $table->string('dias_curso')->nullable();
            $table->string('horas_curso')->nullable();
            /*$table->string('cursos_realizados');
            $table->string('institucion_curso')->nullable();
            $table->date('fecha_finalizacion_curso')->nullable();
            $table->string('descripcion_curso')->nullable();*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formacion_academicas');
    }
};
