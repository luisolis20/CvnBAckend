<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaracion_Personal_D extends Model
{
    use HasFactory;
    protected $table = 'declaracion_personal_docentes';
    protected $fillable = [
       'id',
        'CIInfPer',
        'texto',
    ];

    public function infoperdocente()
    {
        return $this->belongsTo(InformacionPersonald::class, 'CIInfPer');
    }
}
