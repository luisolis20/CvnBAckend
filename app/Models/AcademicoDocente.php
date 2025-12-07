<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicoDocente extends Model
{
    use HasFactory;
   protected $table = 'academico_docente';

    // Clave primaria personalizada
    protected $primaryKey = 'ad_id';

    // La clave primaria NO es string
    public $incrementing = true;

    // El tipo de la clave primaria (DOUBLE no existe, se usa float)
    protected $keyType = 'float';

    // La tabla NO tiene timestamps (created_at / updated_at)
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'ciinfper',
        'idper',
        'ad_titulo',
        'ad_institucion',
        'ad_pais',
        'ad_fecha_titulo',
        'ad_regconesup',
        'fecha_reg_conesup',
        'sub_area_conocimiento',
        'ad_estado',
        'ultima_actualizacion',
        'nv_id',
        'ad_archivo',
        'cod_ies',
    ];

    public function infoperdocente()
    {
        return $this->belongsTo(InformacionPersonald::class, 'ciinfper', 'CIInfPer');
    }
    public function institucion()
    {
        return $this->belongsTo(InstEducSup::class, 'ad_institucion', 'cod_ies');
    }
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'nv_id', 'nv_id');
    }
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'cod_pais', 'ad_pais');
    }
    public function periodolectivo()
    {
        return $this->belongsTo(PeriodoLectivo::class, 'idper', 'idper');
    }
    public function subareaUnesco()
    {
        return $this->belongsTo(SubareaUnesco::class, 'sub_area_conocimiento', 'sau_id');
    }
}
