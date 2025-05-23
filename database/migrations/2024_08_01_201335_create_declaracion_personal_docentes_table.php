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
        Schema::create('declaracion_personal_docentes', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal_d')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('texto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaracion_personal_docentes');
    }
};
