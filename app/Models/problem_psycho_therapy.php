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
        'id_problem'
    ];

    public function problems(){
        return $this->hasMany(Problems::class,'id','id_problem');
    }
}
