<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datos_personale extends Model
{
    use HasFactory;
    protected $table = 'datos_personales';
    protected $fillable = [
        'id',
        'user_id',
       'nombres_apellidos',
       'num_identificacion',
        'fecha_nacimiento',
       'genero',
       'estado_civil',
       'direccion_residencia',
       'telefono',
       'correo_electronico',
        'foto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
