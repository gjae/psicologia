<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problems extends Model
{
     use HasFactory;
    protected $table    = 'problems';
    protected $fillable = ['id_therapy' , 'problem'];


    public function TreatedInTherapy(){
    	return $this->belongsTo(problem_psycho_therapy::class,'id_problem','id');
    }
}
