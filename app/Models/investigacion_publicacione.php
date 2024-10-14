<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class investigacion_publicacione extends Model
{
    use HasFactory;
    protected $table = 'investigacion_publicaciones';
    protected $fillable = [
        'id',
       'CIInfPer',
        'publicaciones',
        'publicacion_tipo',
        'publicacion_titulo',
        'link_publicación',
        'congreso_evento',
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
}
