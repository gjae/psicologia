<?php



namespace App\Models;



use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Recoverpass;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;

use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable //implements MustVerifyEmail

{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;



    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */

    protected $fillable = [

        'name',

        'lastname',

        'phone',

        'gender',

        'age',

        //'role',

        'email',

        'password',

    ];

    public function IsPsychologist() {

    	return $this->hasOne(Psychologist::class,'id_user','id');

    }

    public function Reservations() {

    	return $this->hasOne(Reservations::class,'id_user','id');

    }
    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Recoverpass($token));
    }

}

