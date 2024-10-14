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
        Schema::create('capacitacion_docente', function (Blueprint $table) {
            $table->id('ccdp_id');
            $table->string('ciinfper');
            $table->char('tcap_id')->nullable();
            $table->string('ccdp_nombre')->nullable();
            $table->string('ccdp_institucion')->nullable();
            $table->integer('ccdp_num_horas')->nullable();
            $table->date('ccdp_fecha_ini')->nullable();
            $table->date('ccdp_fecha_fin')->nullable();
            $table->string('ccdp_archivo');

           
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacitacion_docente');
    }
};
