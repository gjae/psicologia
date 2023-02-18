<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;
    protected $table= 'reservations';
    protected $fillable = ['appointment_date' , 'appointment_info','id_user','id_schedule','cause','number_of_sessions','amount'];

    public function Schedule(){
    	return $this->hasOne(schedules::class,'id','id_schedule');
    }
    public function Patient(){
    	return $this->belongsTo(User::class,'id','id_user');
    }
}
