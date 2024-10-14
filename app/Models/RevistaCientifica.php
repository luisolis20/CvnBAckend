<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevistaCientifica extends Model
{
    use HasFactory;
    protected $table = 'revistas_cientificas';

    protected $primaryKey = 'idrevista';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'nombre_rev', 'issn_rev', 'periocidad_pub_rev', 'area_diciplina_rev',
        'catalogo_basededatos', 'idpais', 'url_rev', 'f_ult_modificacion_rev'
    ];
}
