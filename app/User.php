<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use  Notifiable, HasApiTokens;
    use EntrustUserTrait; // add this trait to your user model

    /**
     * rules validasi untuk data suppliers.
     *
     * @var array
     */
    public static $rules = [
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role_id'  => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'bussiness_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function bussiness()
    {
        return $this->belongsToMany('App\Bussiness');
    }

    public function bussinessUser()
    {
        return $this->belongsToMany('App\BussinessUser', 'bussiness_user', 'user_id');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function hasPermission($permission)
    {
        return !! $this->role->get()->intersect($permission->roles)->count();
    }
}
