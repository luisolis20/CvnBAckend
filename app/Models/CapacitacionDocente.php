<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapacitacionDocente extends Model
{
    use HasFactory;
    protected $table = 'capacitacion_docente';

    protected $primaryKey = 'ccdp_id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'ciinfper', 'tcap_id', 'ccdp_nombre', 'ccdp_institucion', 'ccdp_num_horas',
        'ccdp_fecha_ini', 'ccdp_fecha_fin', 'ccdp_archivo'
    ];

    
}
