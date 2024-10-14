<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacion_Referencia_D extends Model
{
    use HasFactory;
    protected $table = 'informacion_referencia_docentes';
    protected $fillable = [
        'id',
        'CIInfPer',
       'referencia_nombres',
       'referencia_apellidos',
       'referencia_correo_electronico',
       'referencia_telefono',
    ];

   
     public function infoperdocente()
    {
        return $this->belongsTo(InformacionPersonald::class, 'CIInfPer');
    }
}
