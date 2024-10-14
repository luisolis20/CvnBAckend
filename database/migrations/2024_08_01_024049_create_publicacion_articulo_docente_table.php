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
        Schema::create('publicacion_articulo_docente', function (Blueprint $table) {
            $table->id('pad_id');
            $table->string('CIInfPer');
            $table->string('pad_titulo_publicacion')->nullable();
            $table->date('pad_fecha_publica')->comment('fecha publicación artículo');
            $table->integer('pad_participacion')->default(0);
            $table->integer('pad_estado_publicacion')->default(0);
            $table->string('pad_archivo')->comment('archivo del articulo publicado');
            $table->integer('pad_idrevista');
            $table->date('pad_f_ult_modificacion')->nullable();
            $table->string('pad_doi')->nullable();

           
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacion_articulo_docente');
    }
};
