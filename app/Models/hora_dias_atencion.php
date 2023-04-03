<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hora_dias_atencion extends Model
{
    use HasFactory;
    protected $table    = 'hora_dia_atencion';
    protected $fillable = ['id_schedule','id_dia','id_psycho'];

    /*public function HoyAtiendeElPsicologo(){
        return $this->hasOne(Psychologist::class,'id','id_psycho');
    }*/
}
