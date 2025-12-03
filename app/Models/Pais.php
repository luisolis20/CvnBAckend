<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'pais';

    // Clave primaria personalizada (CHAR(2))
    protected $primaryKey = 'cod_pais';

    // La clave primaria no es autoincremental
    public $incrementing = false;

    // Tipo de la clave primaria
    protected $keyType = 'string';

    // La tabla NO tiene timestamps
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'nomb_pais',
        'nacionalidad_pais',
        'estado',
        'codigo',
    ];
   
     public function academicosDocente()
    {
        return $this->hasMany(AcademicoDocente::class, 'ad_pais', 'cod_pais');
    }
}
