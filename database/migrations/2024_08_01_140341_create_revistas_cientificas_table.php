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
        Schema::create('revistas_cientificas', function (Blueprint $table) {
            $table->id('idrevista');
            $table->string('nombre_rev')->nullable()->comment('nombre de la revista');
            $table->string('issn_rev')->nullable()->comment('issn de la revista');
            $table->string('periocidad_pub_rev')->nullable()->comment('periodo de publicación de la revista');
            $table->string('area_diciplina_rev')->nullable();
            $table->string('catalogo_basededatos');
            $table->string('idpais')->nullable()->comment('EC, CN, BR....');
            $table->string('url_rev')->nullable();
            $table->date('f_ult_modificacion_rev')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revistas_cientificas');
    }
};
