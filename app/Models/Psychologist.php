<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psychologist extends Model
{
    use HasFactory;
    protected $table    = 'psychologist';
    protected $fillable = [
        'id_user',
        'bio',
        'ranking',
        'personal_phone',
        'bussiness_phone',
        'photo'];

    public function WorksAtHours(){
    	return $this->hasMany(Schedules::class,'id_psychologist','id');
    }


    public function personalInfo(){
        return $this->belongsTo(User::class,'id_user','id');
    }

    public function TherapiesOffered(){
        return $this->hasMany(Psycho_therapy::class,'id_psycho','id');
    }

}
