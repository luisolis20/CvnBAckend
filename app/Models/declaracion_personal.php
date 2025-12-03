<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class declaracion_personal extends Model
{
    use HasFactory;
    protected $table = 'declaracion_personals';
    protected $fillable = [
       'id',
        'CIInfPer',
        'texto',
    ];

    public function infoper()
    {
        return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
    }
    public function infoperdoc()
    {
        return $this->belongsTo(InformacionPersonald::class, 'CIInfPer');
    }
    
}
