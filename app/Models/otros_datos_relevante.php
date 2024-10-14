<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otros_datos_relevante extends Model
{
    use HasFactory;
    protected $table = 'otros_datos_relevantes';
    protected $fillable = [
        'id',
        'CIInfPer',
        'tipo_logros',
        'descripcion_logros',
        'descripcion_fracasos',
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
}
