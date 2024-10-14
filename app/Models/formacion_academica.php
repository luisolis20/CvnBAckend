<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formacion_academica extends Model
{
    use HasFactory;
    protected $table = 'formacion_academicas';
    protected $fillable = [
       'id',
       'CIInfPer',
      'estudios_bachiller_culminados',
      'titulo_bachiller_obtenido',
      'institucion_bachiller',
       'fecha_graduacion_bachiller',
      'especialidad_bachiller',
      'estudios_universitarios_culminados',
      'titulo_universitario_obtenido',
      'institucion_universitaria',
       'fecha_graduacion',
      'especialidad',
      'estudios_posgrado_culminados',
      'titulo_posgrado_obtenido',
      'institucion_posgrado',
       'fecha_graduacion_posgrado',
      'especialidad_posgrado',
     
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
   
}
