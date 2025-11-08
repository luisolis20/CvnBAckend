<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informacionpersonal extends Model
{
    use HasFactory;
   
    protected $table = 'informacionpersonal';
    protected $primaryKey = 'CIInfPer';
    public $incrementing = false;
    protected $keyType = 'string';
    //public const UPDATED_AT = 'ultima_actualizacion';
    public const CREATED_AT = null;
     // 🚫 Ocultamos el campo binario original
    protected $hidden = ['fotografia'];

    // ✅ Agregamos atributo calculado
    protected $appends = ['foto_base64'];
    protected $fillable = [
        'CIInfPer',
        'cedula_pasaporte',
        'TipoDocInfPer',
        'ApellInfPer',
        'ApellMatInfPer',
        'NombInfPer',
        'NacionalidadPer',
        'EtniaPer',
        'tipo_nacionalidad',
        'FechNacimPer',
        'LugarNacimientoPer',
        'GeneroPer',
        'orientacionsexual',
        'EstadoCivilPer',
        'CiudadPer',
        'DirecDomicilioPer',
        'Telf1InfPer',
        'CelularInfPer',
        'TipoInfPer',
        'statusper',
        'mailPer',
        'mailInst',
        'GrupoSanguineo',
        'tipo_discapacidad',
        'carnet_conadis',
        'num_carnet_conadis',
        'porcentaje_discapacidad',
        'fotografia',
        'codigo_dactilar',
        'hd_posicion',
        'huella_dactilar',
        'codigo_verificacion',
        'entregofichamedica',
        'provinciaresidencia',
        'cantonresidencia',
        'idoperadora',
        'idparroquia',
        'nombreparentesco',
        'parentesco',
        'telefonoparentesco',
        'celularparentesco',
        'direccionparentesco',
        'informacionpersonalcol',
        'paisresidencia',
        'idparroquiaresidencia',
        'sectorresi',
        'calleprincipalresi',
        'callesecundariaresi',
        'barrioresi',
        'referenciaresi',
        'numerocasaresi',
        'tieneagua',
        'tienealcantarillado',
        'tienetelefonofijo',
        'tieneinternet',
        'tienetvcable',
        'ingresofamiliar',
        'actividaddelestudiante',
        'finalizofichase',
        'finalizofichasg',
        'residenteexterior',
        'tiporesidenciaexterior',
        'verification_code',
        'cabezadefamilia',
        'dependepadres',
        'espadresoltero',
        'padresrecibenbono',
        'viveen',
        'viviendaes',
        'estructuravivienda',
        'tieneelectricidad',
    ];
     // ✅ Este accesor devuelve la imagen lista para el frontend
    public function getFotoBase64Attribute()
    {
        if ($this->fotografia) {
            return 'data:image/jpeg;base64,' . base64_encode($this->fotografia);
        }
        return null;
    }
    public function declaracion_personal()
    {
        return $this->hasMany(declaracion_personal::class, 'CIInfPer');
    }
    public function experiencia_profesional()
    {
        return $this->hasMany(experiencia_profesionale::class, 'CIInfPer');
    }
    public function formacion_academica()
    {
        return $this->hasMany(formacion_academica::class, 'CIInfPer');
    }
    public function habilidades_informatica()
    {
        return $this->hasMany(habilidades_informatica::class, 'CIInfPer');
    }
    public function idioma()
    {
        return $this->hasMany(idioma::class, 'CIInfPer');
    }
    public function innformacion_contacto()
    {
        return $this->hasMany(informacion_contacto::class, 'CIInfPer');
    }
    public function investigacion_publicaciones()
    {
        return $this->hasMany(investigacion_publicacione::class, 'CIInfPer');
    }
    public function otros_datos()
    {
        return $this->hasMany(otros_datos_relevante::class, 'CIInfPer');
    }
    public function fichasocioeconomica()
    {
        return $this->hasMany(otros_datos_relevante::class, 'CIInfPer');
    }

}
