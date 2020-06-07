<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bussiness extends Model
{
    /**
     * rules validasi untuk data customers.
     *
     * @var array
     */
    public static $rules = [
        'userId'      => 'required',
        'name'        => 'required|unique:bussinesses',
        'description' => 'max:500'
    ];
    
    /**
     * setup variable mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'userId', 'name', 'description',
    ];

    public function bussinessRole()
    {
        return $this->belongsToMany('App\User', 'busId');
    }
    
}
