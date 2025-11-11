<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curso_capacitacion extends Model
{
    use HasFactory;
    protected $table = 'curso_capacitaciones';
    protected $fillable = [
        'id',
        'CIInfPer',
       'intitucion_curso',
       'tipo_evento',
        'area_estudios',
       'nombre_evento',
       'facilitador_curso',
       'tipo_certificado',
       'fecha_inicio_curso',
       'fecha_fin_curso',
       'dias_curso',
        'horas_curso',
        'certificado_curso',
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
}
