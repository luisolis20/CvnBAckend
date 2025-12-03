<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'nivel';

    // Clave primaria
    protected $primaryKey = 'nv_id';

    // Indica que es autoincremental
    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // La tabla NO tiene timestamps
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'nv_numnivel',
        'nv_descripcion',
        'nv_formacion',
    ];

    // Relación opcional: un nivel puede tener muchos académico_docente
    
    public function academicosDocente()
    {
        return $this->hasMany(AcademicoDocente::class, 'nv_id', 'nv_id');
    }
    
}
