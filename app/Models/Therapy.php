<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapy extends Model
{
    use HasFactory;
    protected $table    = 'therapy';
    protected $fillable = ['therapy_type' ,'description'];

    public function TreatProblem() {
    	return $this->hasOne(Problems::class,'id_therapy','id');
    }
    public function Specialist() {
    	return $this->belongsTo(User::class,'id_therapy','id');
    }
}
