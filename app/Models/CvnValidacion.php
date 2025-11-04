<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvnValidacion extends Model
{
    protected $table = 'cvn_validaciones';

    protected $fillable = [
        'CIInfPer',
        'nombres',
        'apellidos',
        'codigo_unico',
        'fecha_generacion'
    ];

    
}
