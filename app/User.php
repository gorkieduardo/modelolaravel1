<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


//TODO: MustVerifyEmail es para que los usuarios confirmen su email
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //evento cuando un usuario es creado
    protected static function boot()
    {
        parent::boot();
        //asingar perfil una vez creado el usuario
        static::created(function ($user) {

            $user->perfil()->create();
        });
    }


    /**Relacion de 1:n */

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
    //relaion 1  a 1 de usuario y perfil
    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }

    //recetas a la que el usuariole ha dado me gusta
    public function meGusta()
    {
        return $this->belongsToMany(Receta::class, 'likes_receta');
    }
}
