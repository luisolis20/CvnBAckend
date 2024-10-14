<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informacion_contacto extends Model
{
    use HasFactory;
    protected $table = 'informacion_contactos';
    protected $fillable = [
        'id',
        'CIInfPer',
       'referencia_nombres',
       'referencia_apellidos',
       'referencia_correo_electronico',
       'referencia_telefono',
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
   
}
