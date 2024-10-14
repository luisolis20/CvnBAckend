<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class habilidades_informatica extends Model
{
    use HasFactory;
    protected $table = 'habilidades_informaticas';
    protected $fillable = [
       'id',
      'CIInfPer',
      'habilidades_comunicativas',
      'descripcion_habilidades_comunicativas',
      'habilidades_creativas',
      'descripcion_habilidades_creativas',
      'habilidades_liderazgo',
      'descripcion_habilidades_liderazgo',
      'habilidades_informaticas_cv',
      'descripcion_habilidades_informaticas_cv',
      'oficios_subactividades',
      'descripcion_oficios_subactividades',
      'otro_habilidades',
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
    
}
