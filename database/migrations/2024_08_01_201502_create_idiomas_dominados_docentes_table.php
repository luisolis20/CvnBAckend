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
        Schema::create('idiomas_dominados_docentes', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal_d')->onDelete('cascade')->onUpdate('cascade');
            $table->string('idioma')->nullable();
            $table->string('comprension_auditiva')->nullable();
            $table->string('comprension_lectura')->nullable();
            $table->string('interaccion_oral')->nullable();
            $table->string('expresion_oral')->nullable();
            $table->string('expresion_escrita')->nullable();
            $table->longtext('certificado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idiomas_dominados_docentes');
    }
};
