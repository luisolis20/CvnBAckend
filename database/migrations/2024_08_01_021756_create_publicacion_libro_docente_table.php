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
        Schema::create('publicacion_libro_docente', function (Blueprint $table) {
            $table->id('pld_id');
            $table->string('CIInfPer');
            $table->string('pld_titulo_libro')->nullable();
            $table->date('pld_fecha_publica');
            $table->tinyInteger('pld_participacion')->default(0);
            $table->char('pld_revision_pares')->nullable()->comment('SI - NO');
            $table->char('pld_isbn')->nullable();
            $table->string('pld_archivo')->nullable()->comment('certificado del libro publicado');
            $table->string('pld_url')->nullable();
            $table->date('pld_f_ult_modificacion')->nullable();
            $table->integer('estado_publicacion')->default(0);
            
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal_d')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacion_libro_docente');
    }
};
