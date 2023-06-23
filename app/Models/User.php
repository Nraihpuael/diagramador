<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function diagramas(){
        return $this->hasMany(Diagrama::class);
    }

    public function misDiagramas(){
        return $this->belongsToMany(Diagrama::class, 'user_diagramas');
    }

    public function user_diagramas(){
        return $this->hasMany(User_diagrama::class);
    }

    public function invitaciones(){
        return $this->hasMany(Notificacion::class);
    }

    public function invitacion($diagrama_id){
        $notificacion = $this->invitaciones()->where('diagrama_id', $diagrama_id)->get();
        $id = 0;
        foreach ($notificacion as $noti) {
            $id = $noti->id;
        }
        return $id;
    }
}
