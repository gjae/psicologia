<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class problem_psycho_therapy extends Model
{
    use HasFactory;
    protected $table = 'problem_psycho_therapy';
    protected $fillable= [
        'id_psycho_therapy',
        'id_problem',
        'id_therapy'
    ];

    public function problems(){
        return $this->hasMany(Problems::class,'id','id_problem');
    }

    public function psycho_therapy(){
        return $this->hasOne(Psycho_therapy::class,'id','id_psycho_therapy');
    }
}
