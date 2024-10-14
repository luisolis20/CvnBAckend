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
        Schema::create('investigacion_publicaciones', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal')->onDelete('cascade')->onUpdate('cascade');
            $table->string('publicaciones')->nullable();
            $table->string('publicacion_tipo')->nullable();
            $table->string('publicacion_titulo')->nullable();
            $table->string('link_publicación')->nullable();
            $table->string('congreso_evento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigacion_publicaciones');
    }
};
