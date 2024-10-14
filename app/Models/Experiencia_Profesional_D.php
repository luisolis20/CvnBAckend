<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia_Profesional_D extends Model
{
    use HasFactory;
    protected $table = 'experiencia_profesional_docentes';
    protected $fillable = [
        'id',
       'CIInfPer',
       'cargos_desempenados',
       'empresa_institucion',
       'fecha_inicio_empresa',
       'fecha_fin_empresa',
       'cargo_desempenado_empresa',
       'descripcion_funciones_empresa',
       'logros_resultados_empresa',
       'practicas_profesionales',
       'empresa_institucion_practicas',
       'fecha_inicio_practicas',
       'fecha_fin_practicas',
       'area_trabajo_practicas',
       'descripcion_funciones_practicas',
    ];

   
    public function infoperdocente()
    {
        return $this->belongsTo(InformacionPersonald::class, 'CIInfPer');
    }
}
