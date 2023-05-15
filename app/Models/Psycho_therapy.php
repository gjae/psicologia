<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psycho_therapy extends Model
{
    use HasFactory;
    protected $table = 'psycho_therapy';
    protected $fillable= ['id_psycho','id_therapy'];

    
    public function psychologistWhoOffers(){
        return $this->belongsTo(Psychologist::class,'id','id_psycho');
    }
    public function therapy(){
        return $this->hasOne(Therapy::class,'id','id_therapy');
    }
    public function problemsTreated(){
        return $this->hasMany(problem_psycho_therapy::class,'id_psycho_therapy','id');
    }
}
