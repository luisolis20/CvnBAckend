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
        Schema::create('habilidades_informaticas', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal')->onDelete('cascade')->onUpdate('cascade');
            $table->string('habilidades_comunicativas')->nullable();
            $table->longtext('descripcion_habilidades_comunicativas')->nullable();
            $table->string('habilidades_creativas')->nullable();
            $table->longtext('descripcion_habilidades_creativas')->nullable();
            $table->string('habilidades_liderazgo')->nullable();
            $table->longtext('descripcion_habilidades_liderazgo')->nullable();
            $table->string('habilidades_informaticas_cv')->nullable();
            $table->longtext('descripcion_habilidades_informaticas_cv')->nullable();
            $table->string('oficios_subactividades')->nullable();
            $table->longtext('descripcion_oficios_subactividades')->nullable();
            $table->longtext('otro_habilidades')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habilidades_informaticas');
    }
};
