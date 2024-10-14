<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idiomas_D extends Model
{
    use HasFactory;
    protected $table = 'idiomas_dominados_docentes';
    protected $fillable = [
       'id',
       'CIInfPer',
       'idioma',
       'comprension_auditiva',
       'comprension_lectura',
       'interaccion_oral',
       'expresion_oral',
       'expresion_escrita',
       'certificado',
    ];

    
    public function infoperdocente()
    {
        return $this->belongsTo(InformacionPersonald::class, 'CIInfPer');
    }
}
