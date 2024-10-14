<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class idioma extends Model
{
    use HasFactory;
    protected $table = 'idiomas';
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

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
    
}
