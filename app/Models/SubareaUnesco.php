<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubareaUnesco extends Model
{
    use HasFactory;
   // Nombre de la tabla
    protected $table = 'subarea_unesco';

    // Clave primaria tipo CHAR(4)
    protected $primaryKey = 'sau_id';

    // No es autoincremental
    public $incrementing = false;

    // Tipo string para la PK
    protected $keyType = 'string';

    // La tabla no usa timestamps
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'sau_pdid',
        'sau_descripcion',
    ];
   
     public function academicosDocente()
    {
        return $this->hasMany(AcademicoDocente::class, 'sub_area_conocimiento', 'sau_id');
    }
}
