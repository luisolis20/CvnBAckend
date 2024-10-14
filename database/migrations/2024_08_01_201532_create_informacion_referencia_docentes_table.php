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
        Schema::create('informacion_referencia_docentes', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal_d')->onDelete('cascade')->onUpdate('cascade');
            $table->string('referencia_nombres')->nullable();
            $table->string('referencia_apellidos')->nullable();
            $table->string('referencia_correo_electronico')->nullable();
            $table->string('referencia_telefono')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_referencia_docentes');
    }
};
