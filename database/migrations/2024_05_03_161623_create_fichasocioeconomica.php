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
        Schema::create('fichasocioeconomica', function (Blueprint $table) {
            $table->id('idfichasocioeconomica');
            $table->string('CIInfPer');
            $table->integer('idper')->nullable();
            $table->string('CelularInfPer')->nullable();
            $table->string('Telf1InfPer')->nullable();
            $table->date('FechNacimPer')->nullable();
            $table->smallInteger('EtniaPer')->default(0);
            $table->integer('tipo_nacionalidad')->default(35);
            $table->char('tipo_discapacidad')->default('N')->comment('tipo de discapacidad');
            $table->char('carnet_conadis')->default('NO')->comment('indica si tiene carnet del conadis');
            $table->string('num_carnet_conadis')->comment('numero de carnet del conadis si lo tiene');
            $table->char('EstadoCivilPer')->default('0');
            $table->smallInteger('GrupoSanguineo')->default(0);
            $table->char('GeneroPer')->default('M');
            $table->tinyInteger('orientacionsexual')->nullable();
            $table->char('mailPer')->nullable();
            $table->char('mailInst')->nullable();
            $table->string('NacionalidadPer')->default('EC');
            $table->string('idparroquia')->default('080103')->comment('parroquia nacimiento');
            $table->string('nombreparentesco')->nullable();
            $table->string('parentesco')->nullable();
            $table->string('telefonoparentesco')->nullable();
            $table->string('celularparentesco')->nullable();
            $table->string('direccionparentesco')->nullable();
            $table->integer('idoperadora')->default(0);
            $table->smallInteger('porcentaje_discapacidad')->default(0)->comment('procentaje de discapacidad que tiene');
            $table->char('paisresidencia')->default('EC');
            $table->string('idparroquiaresidencia')->nullable();
            $table->string('sectorresi')->nullable();
            $table->string('calleprincipalresi')->nullable();
            $table->string('callesecundariaresi')->nullable();
            $table->string('barrioresi')->nullable();
            $table->string('referenciaresi')->nullable();
            $table->string('numerocasaresi')->nullable();
            $table->integer('provinciaresidencia')->default(8);
            $table->integer('cantonresidencia')->default(67);
            $table->char('dependepadres');
            $table->char('espadresoltero');
            $table->char('padresrecibenbono');
            $table->string('viveen');
            $table->string('viviendaes');
            $table->string('estructuravivienda');
            $table->char('tieneelectricidad');
            $table->char('tieneagua');
            $table->char('tienealcantarillado');
            $table->char('tienetelefonofijo');
            $table->char('tieneinternet');
            $table->char('tienetvcable');
            $table->string('ingresofamiliar');
            $table->text('actividaddelestudiante');
            $table->char('cabezadefamilia');
            $table->string('DirecDomicilioPer')->nullable();
            $table->dateTime('ultima_actualizacion');
            $table->integer('idcolegio')->nullable();
            $table->string('NombColegio')->nullable()->comment('nombre del colegio del cual proviene el estudiante o aspirante');
            $table->string('Bachillerato')->nullable()->comment('tipo de bachillerato del estudiante');
            $table->string('Procedencia')->nullable()->comment('La procedencia del estudiante tipo de colegio del cual proviene');
            $table->date('FechGrado')->nullable()->comment('fecha de graduación en secuandaria del estudiante');
            $table->float('CalifGrado')->nullable()->comment('calificación de grado');
            $table->string('provincia')->nullable()->comment('provincia en el cual consta el colegio en el que se graduo el estudiante');
            $table->string('Especialidad')->nullable()->comment('Especialidad en la que se graduo el estudiante');
            $table->char('otrostitulos')->default('NO');
            $table->string('nivel')->default('NINGUNO');
            $table->char('otracarrera')->default('NO');
            $table->string('idpais')->nullable();
            $table->string('idprovincia')->nullable();
            $table->string('idcanton')->nullable();
            $table->char('residenteexterior')->nullable();
            $table->string('tiporesidenciaexterior')->nullable();
            
            $table->unique(['CIInfPer', 'idper']);
            $table->index('CIInfPer');
            
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichasocioeconomica');
    }
};
