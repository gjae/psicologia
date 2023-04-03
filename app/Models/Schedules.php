<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory;
    protected $table    = 'schedules';
    protected $fillable = ['id_psychologist','schedule','id_dia'];

    public function AtThisHourPsyc() {
    	return $this->hasOne(Psychologist::class,'id','id_psychologist');
    }

    public function AtThisHourReservations() {
    	return $this->hasOne(reservations::class,'id','id_psychologist');
    }
}
