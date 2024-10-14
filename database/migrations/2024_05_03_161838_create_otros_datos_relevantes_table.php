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
        Schema::create('otros_datos_relevantes', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tipo_logros')->nullable();
            $table->longText('descripcion_logros')->nullable();
            $table->longText('descripcion_fracasos')->nullable();
            /*$table->string('membresia_asociaciones')->nullable();
            $table->string('hobbies_intereses')->nullable();*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otros_datos_relevantes');
    }
};
