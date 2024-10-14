<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicacionLibroDocente extends Model
{
    use HasFactory;
    protected $table = 'publicacion_libro_docente';

    protected $primaryKey = 'pld_id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'CIInfPer', 'pld_titulo_libro', 'pld_fecha_publica', 'pld_participacion', 'pld_revision_pares', 'pld_isbn',
        'pld_archivo', 'pld_url', 'pld_f_ult_modificacion', 'estado_publicacion'
    ];

    public function informacionPersonal()
    {
        return $this->belongsTo(InformacionPersonald::class, 'CIInfPer', 'CIInfPer');
    }
}
