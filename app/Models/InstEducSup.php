<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstEducSup extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'inst_educ_sup';

    // Clave primaria personalizada
    protected $primaryKey = 'cod_ies';

    // La clave primaria tipo CHAR(4) no es autoincremental
    public $incrementing = false;

    // Tipo de dato de la clave primaria
    protected $keyType = 'string';

    // La tabla NO tiene timestamps
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'nomb_ies',
        'cod_pais',
        'estado',
    ];


   
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'cod_pais', 'cod_pais');
    }
    public function academicosDocente()
    {
        return $this->hasMany(AcademicoDocente::class, 'cod_ies', 'ad_institucion');
    }

}
