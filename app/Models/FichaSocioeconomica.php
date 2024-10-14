<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaSocioeconomica extends Model
{
    use HasFactory;
    protected $table = 'fichasocioeconomica';

    protected $primaryKey = 'idfichasocioeconomica';

    public $timestamps = false;

    protected $fillable = [
        'CIInfPer', 'idper', 'CelularInfPer', 'Telf1InfPer', 'FechNacimPer', 'EtniaPer', 'tipo_nacionalidad', 
        'tipo_discapacidad', 'carnet_conadis', 'num_carnet_conadis', 'EstadoCivilPer', 'GrupoSanguineo', 'GeneroPer', 
        'orientacionsexual', 'mailPer', 'mailInst', 'NacionalidadPer', 'idparroquia', 'nombreparentesco', 'parentesco', 
        'telefonoparentesco', 'celularparentesco', 'direccionparentesco', 'idoperadora', 'porcentaje_discapacidad', 
        'paisresidencia', 'idparroquiaresidencia', 'sectorresi', 'calleprincipalresi', 'callesecundariaresi', 
        'barrioresi', 'referenciaresi', 'numerocasaresi', 'provinciaresidencia', 'cantonresidencia', 'dependepadres', 
        'espadresoltero', 'padresrecibenbono', 'viveen', 'viviendaes', 'estructuravivienda', 'tieneelectricidad', 
        'tieneagua', 'tienealcantarillado', 'tienetelefonofijo', 'tieneinternet', 'tienetvcable', 'ingresofamiliar', 
        'actividaddelestudiante', 'cabezadefamilia', 'DirecDomicilioPer', 'ultima_actualizacion', 'idcolegio', 
        'NombColegio', 'Bachillerato', 'Procedencia', 'FechGrado', 'CalifGrado', 'provincia', 'Especialidad', 
        'otrostitulos', 'nivel', 'otracarrera', 'idpais', 'idprovincia', 'idcanton', 'residenteexterior', 
        'tiporesidenciaexterior'
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
}
