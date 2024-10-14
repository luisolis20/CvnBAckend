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
        Schema::create('informacionpersonal', function (Blueprint $table) {
            $table->string('CIInfPer')->primary();
            $table->string('cedula_pasaporte')->nullable();
            $table->char('TipoDocInfPer')->nullable();
            $table->string('ApellInfPer')->nullable();//si
            $table->string('ApellMatInfPer')->nullable();//si
            $table->string('NombInfPer')->nullable();//si
            $table->string('NacionalidadPer')->nullable();//si
            $table->smallInteger('EtniaPer')->nullable();//si
            $table->integer('tipo_nacionalidad')->nullable();
            $table->date('FechNacimPer')->nullable();//si
            $table->string('LugarNacimientoPer')->nullable();//si
            $table->char('GeneroPer')->nullable();//si
            $table->integer('orientacionsexual')->nullable();//si
            $table->char('EstadoCivilPer')->nullable();
            $table->string('CiudadPer')->nullable();//si
            $table->string('DirecDomicilioPer')->nullable();//si
            $table->string('Telf1InfPer')->nullable();//si
            $table->string('CelularInfPer')->nullable();//si
            $table->char('TipoInfPer')->nullable();
            $table->integer('statusper')->nullable();
            $table->char('mailPer')->nullable();//si
            $table->char('mailInst')->nullable();//si
            $table->smallInteger('GrupoSanguineo')->nullable();
            $table->char('tipo_discapacidad')->nullable();
            $table->char('carnet_conadis')->nullable();
            $table->string('num_carnet_conadis')->nullable();
            $table->smallInteger('porcentaje_discapacidad')->nullable();
            $table->binary('fotografia')->nullable();//si
            $table->string('codigo_dactilar')->nullable();//si
            $table->tinyInteger('hd_posicion')->nullable();
            $table->longText('huella_dactilar')->nullable();
 
            //$table->timestamps('ultima_actualizacion');
            $table->string('codigo_verificacion')->nullable();
            $table->tinyInteger('entregofichamedica')->nullable();
            $table->integer('provinciaresidencia')->nullable();//si
            $table->integer('cantonresidencia')->nullable();//si
            $table->integer('idoperadora')->nullable();//si
            $table->string('idparroquia')->nullable();//si
            $table->string('nombreparentesco')->nullable();//si
            $table->string('parentesco')->nullable();//si
            $table->string('telefonoparentesco')->nullable();//si
            $table->string('celularparentesco')->nullable();//si
            $table->string('direccionparentesco')->nullable();
            $table->string('informacionpersonalcol')->nullable();
            $table->char('paisresidencia')->nullable();//si
            $table->string('idparroquiaresidencia')->nullable();
            $table->string('sectorresi')->nullable();
            $table->string('calleprincipalresi')->nullable();
            $table->string('callesecundariaresi')->nullable();
            $table->string('barrioresi')->nullable();
            $table->string('referenciaresi')->nullable();//si
            $table->string('numerocasaresi')->nullable();//si
            $table->char('cabezadefamilia')->nullable();
            $table->char('dependepadres')->nullable();
            $table->char('espadresoltero')->nullable();
            $table->char('padresrecibenbono')->nullable();
            $table->string('viveen')->nullable();
            $table->string('viviendaes')->nullable();
            $table->string('estructuravivienda')->nullable();
            $table->char('tieneelectricidad')->nullable();
            $table->char('tieneagua')->nullable();
            $table->char('tienealcantarillado')->nullable();
            $table->char('tienetelefonofijo')->nullable();
            $table->char('tieneinternet')->nullable();
            $table->char('tienetvcable')->nullable();
            $table->string('ingresofamiliar')->nullable();
            $table->text('actividaddelestudiante')->nullable();
            $table->tinyInteger('finalizofichase')->nullable();
            $table->tinyInteger('finalizofichasg')->nullable();
            $table->string('residenteexterior')->nullable();
            $table->string('tiporesidenciaexterior')->nullable();
            $table->string('verification_code')->nullable();
            $table->timestamps(false);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacionpersonal');
    }
};
