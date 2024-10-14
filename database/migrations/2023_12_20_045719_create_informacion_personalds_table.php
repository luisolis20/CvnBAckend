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
        Schema::create('informacionpersonal_d', function (Blueprint $table) {
            $table->string('CIInfPer', 20)->primary();
            $table->string('cedula_pasaporte', 13)->nullable();
            $table->char('TipoDocInfPer', 1)->nullable();
            $table->string('ApellInfPer', 45)->nullable();
            $table->string('ApellMatInfPer', 45)->nullable();
            $table->string('NombInfPer', 45)->nullable();
            $table->string('NacionalidadPer', 45)->nullable();
            $table->smallInteger('EtniaPer')->nullable()->comment('etnia del docente');
            $table->date('FechNacimPer')->nullable();
            $table->string('LugarNacimientoPer', 45)->nullable();
            $table->char('GeneroPer', 1)->nullable();
            $table->char('EstadoCivilPer', 1)->nullable();
            $table->string('CiudadPer', 45)->nullable();
            $table->string('DirecDomicilioPer', 45)->nullable();
            $table->string('Telf1InfPer', 12)->nullable();
            $table->string('Telf2InfPer', 12)->nullable();
            $table->string('CelularInfPer', 12)->nullable();
            $table->char('TipoInfPer', 2)->default('D');
            $table->char('StatusPer', 1)->default('1');
            $table->char('mailPer', 60)->nullable();
            $table->char('mailInst', 60)->nullable();
            $table->smallInteger('GrupoSanguineo')->nullable();
            $table->char('tipo_discapacidad', 1)->nullable();
            $table->char('carnet_conadis', 2)->nullable();
            $table->string('num_carnet_conadis', 20)->nullable();
            $table->smallInteger('porcentaje_discapacidad')->nullable();
            $table->binary('fotografia')->nullable();
            $table->char('codigo_dactilar', 15)->nullable()->comment('codigo dactilar de la cedula');
            $table->binary('huella_dactilar')->nullable()->comment('captura informacion de la huella dactilar del docente');
            $table->dateTime('ultima_actualizacion')->nullable();
            $table->string('LoginUsu', 20)->nullable()->comment('login de usuario para el docente');
            $table->string('ClaveUsu', 100)->nullable()->comment('contraseña de acceso al sistema del docente');
            $table->tinyInteger('StatusUsu')->default(1)->comment('Indica el estado de habilitado o bloqueado');
            $table->char('idcarr', 10)->nullable()->comment('identificador de carrera para el docente');
            $table->tinyInteger('usa_biometrico')->nullable()->comment('indica si el docnete tendra acceso mediante el biometrico');
            $table->dateTime('fecha_reg')->nullable()->comment('indica la fecha de registro y crecaion del usuario');
            $table->dateTime('fecha_ultimo_acceso')->nullable()->comment('indica la fecha de ultimo acceso del usuario');
            $table->string('usu_registra', 20)->nullable()->comment('usuario que creo el registro');
            $table->string('usu_modifica', 20)->nullable();
            $table->dateTime('fecha_ultima_modif')->nullable();
            $table->string('usu_modifica_clave', 20)->nullable();
            $table->dateTime('fecha_ultima_modif_clave')->nullable();
            $table->boolean('actualizoDP')->default(0)->comment('verifica si actualizo los adtos personales');
            $table->string('idprovincia', 10)->nullable();
            $table->string('idcanton', 10)->nullable();
            $table->string('idparroquia', 10)->nullable();
            $table->string('direccion2', 245)->nullable();
            $table->string('numerocasa', 45)->nullable();
            $table->string('idprovinciacasa', 10)->nullable();
            $table->string('idcantoncasa', 10)->nullable();
            $table->string('idparroquiacasa', 10)->nullable();
            $table->string('referenciacasa', 245)->nullable();
            $table->string('sectorcasa', 45)->nullable();
            $table->string('barriocasa', 245)->nullable();
            $table->string('viviendapropia', 45)->nullable();
            $table->string('padre', 245)->nullable();
            $table->string('madre', 245)->nullable();
            $table->string('conyuge', 245)->nullable();
            $table->integer('nacionalidadetnia')->nullable();
            $table->date('fechaingreso')->nullable();
            $table->date('fechasalida')->nullable();
            $table->tinyInteger('hd_posicion')->nullable();
            $table->string('tipoaccion', 100)->default('OCASIONAL');
            $table->string('denominacion', 100)->default('DOCENTE OCASIONAL');
            $table->string('area', 100)->default('UTLVTE');
            $table->string('cargo', 100)->nullable();
            
            $table->index('tipoaccion', 'fx_informacionpersonal_d_ta_idx');
            $table->index('denominacion', 'fx_informacionpersonal_d_dn_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacionpersonal_d');
    }
};
