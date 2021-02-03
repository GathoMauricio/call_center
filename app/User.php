<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_rol_id',
        'name',
        'middle_name',
        'last_name',
        'email',
        'color',
        'api_token',
        'fcm_token',
        'password',
        'created_at',
        'updated_at'
    ];
    public function rol()
    {
        return $this->belongsTo(
            'App\UserRol',
            'user_rol_id',
            'id'
        )
            ->withDefault();
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
