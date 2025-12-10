<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursaEstudios extends Model
{
    use HasFactory;
   protected $table = 'cursa_estudios';

    // Clave primaria personalizada
    protected $primaryKey = 'ec_id';

    // La clave primaria NO es string
    public $incrementing = true;

    
    protected $keyType = 'int';

    // La tabla NO tiene timestamps (created_at / updated_at)
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'ciinfper',
        'idper',
        'ec_numdoc',
        'ec_titulo',
        'ec_institucion',
        'ad_fecha_titulo',
        'ec_pais',
        'ec_fecha_inicia',
        'ec_fecha_termina',
        'ec_sub_area_conocimiento',
        'ec_estado',
        'ultima_actualizacion',
        'nv_id',
        'ec_archivo',
        'ec_inst_financia',
    ];

    public function infoperdocente()
    {
        return $this->belongsTo(InformacionPersonald::class, 'ciinfper', 'CIInfPer');
    }
    public function institucion()
    {
        return $this->belongsTo(InstEducSup::class, 'ec_institucion', 'cod_ies');
    }
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'nv_id', 'nv_id');
    }
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'cod_pais', 'ec_pais');
    }
    public function periodolectivo()
    {
        return $this->belongsTo(PeriodoLectivo::class, 'idper', 'idper');
    }
    public function subareaUnesco()
    {
        return $this->belongsTo(SubareaUnesco::class, 'ec_sub_area_conocimiento', 'sau_id');
    }
}
