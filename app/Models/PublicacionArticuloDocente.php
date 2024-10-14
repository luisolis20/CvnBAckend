<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicacionArticuloDocente extends Model
{
    use HasFactory;
    protected $table = 'publicacion_articulo_docente';

    protected $primaryKey = 'pad_id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'CIInfPer', 'pad_titulo_publicacion', 'pad_fecha_publica', 'pad_participacion', 'pad_estado_publicacion',
        'pad_archivo', 'pad_idrevista', 'pad_f_ult_modificacion', 'pad_doi'
    ];

   
}
