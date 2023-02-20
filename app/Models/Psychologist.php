<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psychologist extends Model
{
    use HasFactory;
    protected $table= 'psychologist';
    protected $fillable = ['id_user','name','lastname','email','therapy_id','role','personal_phone','bussiness_phone','gender','photo','specialty'];

    public function WorksAtHours(){
    	return $this->hasMany(Schedules::class,'id_psychologist','id');
    }

    public function Therapy(){
        return $this->HasOne(Therapy::class,'id','therapy_id');
    }
    public function personalInfo(){
        return $this->belongsTo(User::class,'id_user','id');
    }
}
