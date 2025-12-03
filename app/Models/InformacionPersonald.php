<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionPersonald extends Model
{
    use HasFactory;
    protected $table = 'informacionpersonal_d';

    protected $primaryKey = 'CIInfPer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CIInfPer', 'cedula_pasaporte', 'TipoDocInfPer', 'ApellInfPer', 'ApellMatInfPer', 'NombInfPer', 'NacionalidadPer', 
        'EtniaPer', 'FechNacimPer', 'LugarNacimientoPer', 'GeneroPer', 'EstadoCivilPer', 'CiudadPer', 'DirecDomicilioPer', 
        'Telf1InfPer', 'Telf2InfPer', 'CelularInfPer', 'TipoInfPer', 'StatusPer', 'mailPer', 'mailInst', 'GrupoSanguineo', 
        'tipo_discapacidad', 'carnet_conadis', 'num_carnet_conadis', 'porcentaje_discapacidad', 'fotografia', 'codigo_dactilar', 
        'huella_dactilar', 'ultima_actualizacion', 'LoginUsu', 'ClaveUsu', 'StatusUsu', 'idcarr', 'usa_biometrico', 'fecha_reg', 
        'fecha_ultimo_acceso', 'usu_registra', 'usu_modifica', 'fecha_ultima_modif', 'usu_modifica_clave', 'fecha_ultima_modif_clave', 
        'actualizoDP', 'idprovincia', 'idcanton', 'idparroquia', 'direccion2', 'numerocasa', 'idprovinciacasa', 'idcantoncasa', 
        'idparroquiacasa', 'referenciacasa', 'sectorcasa', 'barriocasa', 'viviendapropia', 'padre', 'madre', 'conyuge', 
        'nacionalidadetnia', 'fechaingreso', 'fechasalida', 'hd_posicion', 'tipoaccion', 'denominacion', 'area', 'cargo'
    ];
    protected $hidden = ['ClaveUsu', 'fotografia']; 
    /*public function publicacionlibrodocente()
    {
        return $this->hasMany(PublicacionLibroDocente::class, 'CIInfPer');
    }
    public function Declaracion_Personal_D()
    {
        return $this->hasMany(Declaracion_Personal_D::class, 'CIInfPer');
    }
    public function Experiencia_Profesional_D()
    {
        return $this->hasMany(Experiencia_Profesional_D::class, 'CIInfPer');
    }
    public function Formacion_Academica_D()
    {
        return $this->hasMany(Formacion_Academica_D::class, 'CIInfPer');
    }
    public function Habilidades_Inform_D()
    {
        return $this->hasMany(Habilidades_Inform_D::class, 'CIInfPer');
    }
    public function Idiomas_D()
    {
        return $this->hasMany(Idiomas_D::class, 'CIInfPer');
    }
    public function Informacion_Referencia_D()
    {
        return $this->hasMany(Informacion_Referencia_D::class, 'CIInfPer');
    }*/
   
}
